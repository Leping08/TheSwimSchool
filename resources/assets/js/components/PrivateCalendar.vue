<template>
    <div class="">
        <div class="uk-grid uk-width-1-1">
            <FullCalendar
                    class="uk-width-3-4@m uk-margin-bottom"
                    :height="600"
                    :plugins="calendarPlugins"
                    :events="calendarEvents"
                    :event-time-format="{ hour12: true, hour: 'numeric', minute: '2-digit' }"
                    @eventClick="eventClicked"
                    :header="{
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                    }"
            ></FullCalendar>
            <div class="uk-width-1-4@m">
                <div v-if="instructors.length" class="uk-card uk-card-default uk-card-body">
                    <h3 class="uk-heading-bullet">Instructors</h3>
                    <div class="" v-for="instructor in instructors" :key="instructor.id">
                        <div class="uk-margin-small uk-text-bold uk-flex">
                            <a class="uk-flex-1" target="_blank" :href="'/about/#' + instructor.name.split(' ')[0]">{{ instructor.name }}</a>
                            <span style="height: 1.5rem; width: 1.5rem; border-radius: 9999px;" :style="'background-color:' + instructor.hex_color + ';'"></span>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="">
                    <div class="uk-grid uk-margin">
                        <div class="uk-h3 uk-width-1-2">Cart</div>
                        <div class="uk-h3 uk-width-1-2 uk-text-right"><i class="fa fa-shopping-cart fa-lg"></i></div>
                    </div>
                    <div v-for="event in cart" class="uk-card uk-card-default uk-card-body uk-width-1-1@m uk-margin">
                        <button @click="remove(event)" class="uk-offcanvas-close uk-button-small" type="button" uk-close></button>
                        <div>{{event.start.toDateString()}}</div>
                        <div>{{event.start.toLocaleTimeString([], {hour: 'numeric', minute:'2-digit', hour12: true})}} - {{event.end.toLocaleTimeString([], {hour: 'numeric', minute:'2-digit', hour12: true})}}</div>
                    </div>
                    <div>
                        <div class="uk-h3 uk-margin-top">Total: ${{ cart.length * 35 }}</div>
                    </div>
                </div>
            </div>
            <input class="" name="pool_session_ids" :value="poolSessionIds" hidden>
        </div>
        <div v-show="cart.length" class="uk-grid uk-width-1-1">
            <slot></slot>
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
                cart: [],
                price: 0,
                alreadyInCart: false
            }
        },
        created() {
            this.calendarEvents = JSON.parse(this.events).map(function(event) {
                return {
                    id: event.id,
                    start: Date.parse(event.start),
                    end: Date.parse(event.end),
                    color: event.instructor.hex_color
                };
            });
        },
        methods: {
            eventClicked: function (event) {
                //Check if the event being added to the cart is a duplicate
                if(this.duplicates(event.event.id)) {
                    return;
                }

                //Add the event to the cart
                this.cart.push({
                    'id': event.event.id,
                    'start': event.event.start,
                    'end': event.event.end
                });

                //Set the color of the selected item
                this.calendarEvents.forEach(function (item) {
                    if(item.id == event.event.id) {
                        item.color = '#7a9fea';
                    }
                })
            },
            remove: function (event) {
                //Remove the event from the cart
                this.cart = this.cart.filter(function (item) {
                    return !(item.id == event.id);
                });

                //Set the color back to the instructor color
                this.calendarEvents.forEach((item) => {
                    if(item.id == event.id) {
                        JSON.parse(this.events).map((original_event) => {
                            if (item.id == original_event.id) {
                                item.color = original_event.instructor.hex_color;
                            }
                        });
                    }
                });
            },
            duplicates: function (event_id) {
                let length =  this.cart.filter(function (item) {
                    return (item.id === event_id);
                }).length;
                return !!length;
            }
        },
        computed: {
            poolSessionIds: function () {
                return this.cart.map(function (item) {
                    return item.id;
                });
            },
            instructors: function () {
                let instructors = JSON.parse(this.events).map(event => event.instructor);
                const seen = new Set();
                return instructors.filter(instructor => {
                    const duplicate = seen.has(instructor.id);
                    seen.add(instructor.id);
                    return !duplicate;
                });
            }
        },
        watch: {
            cart: {
                handler: function (after, before) {
                    window.cartLength = Object.keys(after).length;
                },
                deep: true
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