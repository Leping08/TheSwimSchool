<template>
    <div>
        <FullCalendar
            class="uk-width-4-4@m"
            :plugins="calendarPlugins"
            :events="calendarEvents"
            @eventClick="eventClicked"
            :nowIndicator="true"
            :header="{
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listDay'
            }"
        ></FullCalendar>
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
                cart: [],
                price: 0,
                alreadyInCart: false
            }
        },
        created() {
            this.calendarEvents = JSON.parse(this.events).map(function(event) {
                return {
                    'id': event.id,
                    'title': event.title,
                    'start': Date.parse(event.start),
                    'end': Date.parse(event.end),
                    'color': event.color,
                    'url': event.url
                };
            });
        },
        methods: {
            eventClicked: function (event) {
                console.log(event.event);
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