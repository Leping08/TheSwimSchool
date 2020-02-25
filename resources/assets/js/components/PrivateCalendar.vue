<template>
    <div>
        <FullCalendar
                :plugins="calendarPlugins"
                :events="calendarEvents"
                @eventClick="eventClicked"
                :header="{
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                }"
        ></FullCalendar>
        <div>
            {{cart}}
        </div>
    </div>
</template>

<script>
    import FullCalendar from '@fullcalendar/vue'
    import dayGrid from '@fullcalendar/daygrid'
    import timeGrid from '@fullcalendar/timegrid'
    import interaction from '@fullcalendar/interaction'

    export default {
        components: {
            FullCalendar
        },
        props: [
            'events'
        ],
        name: "PrivateCalendar",
        data() {
            return {
                calendarPlugins: [
                    dayGrid,
                    timeGrid,
                    interaction
                ],
                calendarEvents: [],
                cart: []
            }
        },
        created() {
            this.calendarEvents = JSON.parse(this.events).map(function(event) {
                return {
                    'id': event.id,
                    'title': event.title,
                    'description': 'This is the description',
                    'start': Date.parse(event.start),
                    'end': Date.parse(event.end),
                    'color': event.color
                };
            });
        },
        methods: {
            eventClicked: function (event) {
                let e = event.event;
                this.cart.push({
                    'id': e.id,
                    'end': e.end,
                    'start': e.start
                });
            }
        }
    }
</script>

<style scoped>
    @import '~@fullcalendar/core/main.css';
    @import '~@fullcalendar/daygrid/main.css';
    @import '~@fullcalendar/timegrid/main.css';
</style>