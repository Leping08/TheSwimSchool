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
                    <div v-for="swimmer in selectedEvent.swimmers">
                        <div class="uk-padding-small">
                            <div><i class="fa fa-user uk-margin-small-right" aria-hidden="true"></i> {{ swimmer.firstName || swimmer.first_name }} {{ swimmer.lastName || swimmer.last_name }}</div>
                            <div><i class="fa fa-phone uk-margin-small-right" aria-hidden="true"></i> <a :href="'sms:' + swimmer.phone">{{ swimmer.phone }}</a></div>
                            <div><i class="fa fa-calendar uk-margin-small-right" aria-hidden="true"></i> {{ (swimmer.birthDate || swimmer.birth_date) | age }}</div>
                        </div>
                    </div>
                </div>
                <div class="uk-padding-small">
                    <div class="uk-h5">Wait List:</div>
                    <div v-for="person in selectedEvent.waitList">
                        <div class="uk-padding-small">
                            <div><i class="fa fa-user uk-margin-small-right" aria-hidden="true"></i> {{ person.name }}</div>
                            <div><i class="fa fa-phone uk-margin-small-right" aria-hidden="true"></i> <a :href="'sms:' + person.phone">{{ person.phone }}</a></div>
                            <div><i class="fa fa-calendar uk-margin-small-right" aria-hidden="true"></i> {{ person.date_of_birth | age }}</div>
                        </div>
                    </div>
                </div>
                <div class="uk-padding-small">
                    <a :href="selectedEvent.url" target="_blank" class="uk-button uk-button-primary">Edit</a>
                    <button class="uk-modal-close uk-button uk-button-default" type="button">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
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
                selectedEvent: null
            }
        },
        created() {
            this.calendarEvents = JSON.parse(this.events).map(function(event, index) {
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
        methods: {
            eventClicked: function (event) {
                event.jsEvent.preventDefault(); // don't let the browser navigate
                this.selectedEvent = this.calendarEvents[event.event.id]; //This is the index of the event in the selectedEvent object
                UIkit.modal(this.$refs.modal).show();
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