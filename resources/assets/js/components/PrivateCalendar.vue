<template>
    <div class="">
        <div class="uk-grid uk-width-1-1">
            <FullCalendar
                    class="uk-width-3-4@m"
                    :plugins="calendarPlugins"
                    :events="calendarEvents"
                    @eventClick="eventClicked"
                    :header="{
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                    }"
            ></FullCalendar>
            <div class="uk-width-1-4@m">
                <div class="uk-grid uk-margin-large-top">
                    <div class="uk-h3 uk-width-1-2">Cart</div>
                    <div class="uk-h3 uk-width-1-2 uk-text-right"><i class="fa fa-shopping-cart fa-lg"></i></div>
                </div>
                <div v-for="event in cart" class="uk-card uk-card-default uk-card-body uk-width-1-1@m uk-margin">
                    <button @click="remove(event.id)" class="uk-offcanvas-close uk-button-small" type="button" uk-close></button>
                    <div>{{event.start.toDateString()}}</div>
                    <div>{{event.start.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit', hour12: true})}} - {{event.end.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit', hour12: true})}}</div>
                </div>
                <div>
                    <div class="uk-h3 uk-margin-top">Total: ${{ cart.length * 35 }}</div>
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
                    'id': event.id,
                    'start': Date.parse(event.start),
                    'end': Date.parse(event.end),
                    'color': '#ed64a6'
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
                    'end': event.event.end,
                    'start': event.event.start
                });

                //Set the color of the selected item
                this.calendarEvents.forEach(function (item) {
                    if(item.id == event.event.id) {
                        item.color = '#7a9fea';
                    }
                })
            },
            remove: function (event_id) {
                this.cart = this.cart.filter(function (item) {
                    return !(item.id === event_id);
                });

                //Set the color of the selected item back to the original color
                this.calendarEvents.forEach(function (item) {
                    if(item.id == event_id) {
                        item.color = '#ed64a6';
                    }
                })
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