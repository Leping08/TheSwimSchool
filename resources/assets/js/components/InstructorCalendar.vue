<template>
    <div>
        <FullCalendar class="uk-width-4-4@m" :options="calendarOptions"></FullCalendar>
        <div id="my-id" ref="modal">
            <div class="uk-modal-dialog uk-modal-body" v-if="selectedEvent">
                <h2 class="uk-modal-title">{{ selectedEvent.title }}</h2>
                <div class="uk-padding-small">
                    <div class="uk-h5">Lesson:</div>
                    <div class="uk-padding-small">
                        <div><i class="fa fa-map-marker uk-margin-small-right" aria-hidden="true"></i>{{ selectedEvent.location }}</div>
                        <div><i class="fa fa-play-circle uk-margin-small-right" aria-hidden="true"></i>{{ formatTime(selectedEvent.start) }}</div>
                        <div><i class="fa fa-stop-circle uk-margin-small-right" aria-hidden="true"></i>{{ formatTime(selectedEvent.end) }}</div>
                    </div>
                </div>
                <div class="uk-padding-small" v-if="selectedEvent.swimmers.length">
                    <div class="uk-h5">Swimmers:</div>
                    <div v-for="swimmer in selectedEvent.swimmers" :key="swimmer.id">
                        <div class="uk-padding-small" v-if="swimmer">
                            <div><i class="fa fa-user uk-margin-small-right" aria-hidden="true"></i> {{ swimmer.firstName || swimmer.first_name }} {{ swimmer.lastName || swimmer.last_name }}</div>
                            <div><i class="fa fa-phone uk-margin-small-right" aria-hidden="true"></i> <a :href="'sms:' + swimmer.phone">{{ swimmer.phone }}</a></div>
                            <div><i class="fa fa-clock-o uk-margin-small-right" aria-hidden="true"></i> {{ age(swimmer.birthDate || swimmer.birth_date) }}</div>
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
                            <div><i class="fa fa-clock-o uk-margin-small-right" aria-hidden="true"></i> {{ age(person.date_of_birth) }}</div>
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
    import FullCalendar from '@fullcalendar/vue3';
    import dayGridPlugin from '@fullcalendar/daygrid';
    import timeGridPlugin from '@fullcalendar/timegrid';
    import listPlugin from '@fullcalendar/list';
    import interactionPlugin from '@fullcalendar/interaction';
    import { formatTime, parseDate, yearsOld } from '../dates';

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
                calendarOptions: {
                    plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
                    height: 600,
                    nowIndicator: true,
                    dayMaxEvents: true,
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listDay'
                    },
                    eventClick: this.eventClicked,
                    events: []
                },
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
                    start: parseDate(event.start),
                    end: parseDate(event.end),
                    color: event.color,
                    url: event.details_link,
                    swimmers: event.swimmers,
                    location: event.location,
                    waitList: event.waitList
                };
            });
            this.calendarOptions.events = this.calendarEvents;
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
            formatTime,
            age(date) {
                return yearsOld(date) + ' Years Old';  //TODO Allow for months old
            },
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
        }
    }
</script>
