<template>
    <div class="">
        <div class="uk-grid uk-width-1-1">
            <FullCalendar class="uk-width-3-4@m uk-margin-bottom" :options="calendarOptions"></FullCalendar>
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
                    <div v-for="(event, index) in cart" :key="index" class="uk-card uk-card-default uk-card-body uk-width-1-1@m uk-margin">
                        <button @click="remove(event)" class="uk-offcanvas-close uk-button-small" type="button" uk-close></button>
                        <div>{{event.location_name}}</div>
                        <div>{{event.start.toDateString()}}</div>
                        <div>{{event.start.toLocaleTimeString([], {hour: 'numeric', minute:'2-digit', hour12: true})}} - {{event.end.toLocaleTimeString([], {hour: 'numeric', minute:'2-digit', hour12: true})}}</div>
                        <div>${{event.price}}</div>
                    </div>
                    <div>
                        <div class="uk-h3 uk-margin-top">Total: ${{ cartPrice }}</div>
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
    import FullCalendar from '@fullcalendar/vue3';
    import dayGridPlugin from '@fullcalendar/daygrid';
    import timeGridPlugin from '@fullcalendar/timegrid';
    import interactionPlugin from '@fullcalendar/interaction';
    import { parseDate } from '../dates';

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
                sessions: JSON.parse(this.events),
                cart: []
            }
        },
        methods: {
            eventClicked: function (info) {
                if (this.cart.some(item => item.id === info.event.id)) {
                    return;
                }

                this.cart.push({
                    'id': info.event.id,
                    'start': info.event.start,
                    'end': info.event.end,
                    'location_name': info.event.extendedProps.location.name,
                    'price': info.event.extendedProps.price ?? 35
                });
            },
            remove: function (event) {
                this.cart = this.cart.filter(item => item.id !== event.id);
            }
        },
        computed: {
            calendarOptions: function () {
                return {
                    plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
                    height: 600,
                    eventTimeFormat: { hour12: true, hour: 'numeric', minute: '2-digit' },
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    eventClick: this.eventClicked,
                    events: this.sessions.map(session => ({
                        id: String(session.id),
                        start: parseDate(session.start),
                        end: parseDate(session.end),
                        color: this.cart.some(item => item.id === String(session.id)) ? '#7a9fea' : session.instructor.hex_color,
                        price: session.price,
                        extendedProps: {
                            location: session.location
                        }
                    }))
                };
            },
            poolSessionIds: function () {
                return this.cart.map(item => item.id);
            },
            instructors: function () {
                const seen = new Set();
                return this.sessions.map(session => session.instructor).filter(instructor => {
                    const duplicate = seen.has(instructor.id);
                    seen.add(instructor.id);
                    return !duplicate;
                });
            },
            cartPrice: function () {
                return this.cart.reduce((total, item) => total + item.price, 0);
            }
        },
        watch: {
            cartPrice: function (price) {
                window.cartPrice = price;
            }
        }
    }
</script>
