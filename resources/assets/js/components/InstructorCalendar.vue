<template>
    <div>
        <FullCalendar
            class="uk-width-4-4@m"
            :height="600"
            :plugins="calendarPlugins"
            :events="calendarEvents"
            @eventClick="eventClicked"
            :nowIndicator="true"
            :event-limit="true"
            :header="{
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listDay'
            }"
        ></FullCalendar>
        <div id="my-id" ref="modal">
            <div class="uk-modal-dialog uk-modal-body" v-if="selectedEvent">
                <h2 class="uk-modal-title">{{ selectedEvent.title }}</h2>
                <div class="uk-padding-small">
                    <div class="uk-h5">Lesson:</div>
                    <div class="uk-padding-small">
                        <div><i class="fa fa-map-marker uk-margin-small-right" aria-hidden="true"></i>{{ selectedEvent.location }}</div>
                        <div><i class="fa fa-play-circle uk-margin-small-right" aria-hidden="true"></i>{{ selectedEvent.start | timeFormat }}</div>
                        <div><i class="fa fa-stop-circle uk-margin-small-right" aria-hidden="true"></i>{{ selectedEvent.end | timeFormat }}</div>
                    </div>
                </div>
                <div class="uk-padding-small">
                    <div class="uk-h5">Swimmers:</div>
                    <div v-for="swimmer in selectedEvent.swimmers" :key="swimmer.id">
                        <div class="uk-padding-small" v-if="swimmer">
                            <div><i class="fa fa-user uk-margin-small-right" aria-hidden="true"></i> {{ swimmer.firstName || swimmer.first_name }} {{ swimmer.lastName || swimmer.last_name }}</div>
                            <div><i class="fa fa-phone uk-margin-small-right" aria-hidden="true"></i> <a :href="'sms:' + swimmer.phone">{{ swimmer.phone }}</a></div>
                            <div><i class="fa fa-clock-o uk-margin-small-right" aria-hidden="true"></i> {{ (swimmer.birthDate || swimmer.birth_date) | age }}</div>
                            <div><i class="fa fa-calendar-check-o uk-margin-small-right" aria-hidden="true"></i> {{ swimmer.attendance_count }} Time{{ swimmer.attendance_count >= 2 || swimmer.attendance_count <= 0 ? 's' : '' }}</div>
                            <div v-if="swimmer.attendance">
                                <input class="uk-checkbox" type="checkbox" v-model="swimmer.attendance.attended"> <label for="checkbox" class="uk-margin-small-left">Todays Attendance</label>
                            </div>
                        </div>
                    </div>
                    <div class="uk-padding-small">
                        <a :href="'sms:' + phoneNumbersLinkString" class="uk-button uk-button-secondary" type="button">Text All <i class="fa fa-comment" aria-hidden="true"></i></a>
                    </div>
                </div>
                <div class="uk-padding-small">
                    <div class="uk-h5">Wait List:</div>
                    <div v-for="person in selectedEvent.waitList" :key="person.id">
                        <div class="uk-padding-small" v-if="person">
                            <div><i class="fa fa-user uk-margin-small-right" aria-hidden="true"></i> {{ person.name }}</div>
                            <div><i class="fa fa-phone uk-margin-small-right" aria-hidden="true"></i> <a :href="'sms:' + person.phone">{{ person.phone }}</a></div>
                            <div><i class="fa fa-clock-o uk-margin-small-right" aria-hidden="true"></i> {{ person.date_of_birth | age }}</div>
                        </div>
                    </div>
                </div>
                <div v-if="saveSuccess">
                    <div class="uk-alert-success" uk-alert>
                        <a class="uk-alert-close" @click="clearStates" uk-close></a>
                        <p><strong>Attendance saved!</strong></p>
                    </div>
                </div>
                <div v-if="saveError">
                    <div class="uk-alert-success" uk-alert>
                        <a class="uk-alert-close" @click="clearStates" uk-close></a>
                        <p><strong>Error saving attendance.</strong></p>
                    </div>
                </div>
                <div class="uk-padding-small">
                    <button @click="saveAttendance" class="uk-button uk-button-primary" type="button">Save</button>
                    <a :href="selectedEvent.url" target="_blank" class="uk-button uk-button-default">More Info <i class="fa fa-external-link" aria-hidden="true"></i></a>
                    <button class="uk-modal-close uk-button uk-button-default" type="button">Close</button>
                    <div v-if="saveLoading" uk-spinner="ratio: 0.75"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import FullCalendar from '@fullcalendar/vue'
    import dayGrid from '@fullcalendar/daygrid'
    import timeGrid from '@fullcalendar/timegrid'
    import listPlugin from '@fullcalendar/list';
    import interaction from '@fullcalendar/interaction'

    export default {
        name: "InstructorCalendar",
        components: {
            FullCalendar
        },
        props: [
            'events'
        ],
        data() {
            return {
                calendarPlugins: [
                    dayGrid,
                    timeGrid,
                    listPlugin,
                    interaction
                ],
                calendarEvents: [],
                showModal: false,
                selectedEvent: null,
                saveLoading: false,
                saveSuccess: false,
                saveError: false,
                attended: 2
            }
        },
        created() {
            this.calendarEvents = JSON.parse(this.events).map(function(event, index) {

                // Loop over the swimmers and add the attendance to the swimmer object
                event?.swimmers?.forEach(swimmer => {
                    // Check if the swimmer is a null object
                    if (swimmer === null) {
                        return;
                    }
                    swimmer.attendance = event?.attendances?.find(attendance => attendance?.swimmable_id === swimmer?.id) ?? null;
                    swimmer.attendance_count = swimmer.attendances.filter(attendance => attendance.attended).length ?? 0;
                });

                return {
                    id: index,
                    title: event.title,
                    start: Date.parse(event.start),
                    end: Date.parse(event.end),
                    color: event.color,
                    url: event.details_link,
                    swimmers: event.swimmers,
                    location: event.location,
                    waitList: event.waitList
                };
            });
        },
        computed: {
            phoneNumbers() {
                return this.selectedEvent.swimmers.map(swimmer => swimmer?.phone);
            },
            phoneNumbersLinkString() {
                return this.phoneNumbers.map(phone => {
                    return '+1' + phone.replace(/-/g, '');
                }).join(',');
            }
        },
        methods: {
            eventClicked: function (event) {
                event.jsEvent.preventDefault(); // don't let the browser navigate
                this.clearStates();
                this.selectedEvent = this.calendarEvents[event.event.id]; //This is the index of the event in the selectedEvent object
                UIkit.modal(this.$refs.modal).show();
            },
            clearStates() {
                this.saveSuccess = false;
                this.saveError = false;
            },
            async saveAttendance() {
                // Loop over the swimmers and save the attendance
                this.saveLoading = true;
                let promises = [];
                this.selectedEvent.swimmers.forEach(swimmer => {
                    if (swimmer.attendance) {
                        promises.push(axios.post(`/api/pool-session-attendance/${swimmer.attendance.id}`, {
                            attended: swimmer.attendance.attended
                        }));
                    }
                });

                await Promise.all(promises)
                    .then(responses => {
                        this.saveSuccess = true;
                    })
                    .catch(error => {
                        this.saveError = true;
                    })
                    .finally(() => {
                        this.saveLoading = false;
                    });
            }
        },
        filters: {
            age(date) {
                let today = new Date();
                let birthDate = new Date(date.replace(/ /g,"T"));
                let age = today.getFullYear() - birthDate.getFullYear();
                let m = today.getMonth() - birthDate.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                return age + ' Years Old';  //TODO Allow for months old
            },
            timeFormat(dateTime) {
                //This is for Safari. https://stackoverflow.com/questions/4310953/invalid-date-in-safari
                let d = new Date(dateTime);
                let hours = d.getHours();
                let minutes = d.getMinutes();
                let ampm = hours >= 12 ? 'pm' : 'am';
                hours = hours % 12;
                hours = hours ? hours : 12; // the hour '0' should be '12'
                minutes = minutes < 10 ? '0'+minutes : minutes;
                return hours + ':' + minutes + ' ' + ampm;
            }
        }
    }
</script>

<style scoped>
    @import '~@fullcalendar/core/main.css';
    @import '~@fullcalendar/daygrid/main.css';
    @import '~@fullcalendar/timegrid/main.css';
    @import '~@fullcalendar/list/main.css';
</style>
