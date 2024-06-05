<template>
    <div>
        <div class="uk-flex-middle uk-grid-margin uk-grid" uk-grid="">
            <div class="uk-width-1-1@m uk-first-column uk-flex-middle uk-grid-margin uk-grid">
                <div class="uk-width-1-1@lg uk-width-1-2@m">
                    <div class="uk-h3">
                        Lesson Type
                    </div>
                    <select v-model="lesson_type" @change="lessonTypeChanged" class="uk-select">
                        <option value="group">Group</option>
                        <option value="private">Private</option>
                    </select>
                </div>
                <div class="uk-width-1-1@lg uk-width-1-2@m">
                    <div class="uk-h3">
                        Week
                    </div>
                    <input type="week" name="week" v-model="week" @change="weekChanged" class="uk-input" />
                </div>
            </div>
            <div class="uk-width-1-1@m uk-first-column">
                <div class="uk-margin-bottom">
                    <h2 class="uk-heading-line">
                        <span>
                            {{ swimmers.length }} Swimmers
                        </span>
                    </h2>
                    <div class="uk-overflow-auto">
                        <table class="uk-table uk-table-hover uk-table-divider">
                            <thead>
                                <tr>
                                    <th>Names</th>
                                    <th>Phone</th>
                                    <th>Number of swimmers</th>
                                    <th>Date/Time</th>
                                    <!-- <th>Years Old</th>
                                    <th>Date Of Birth</th>
                                    <th>Email</th>
                                    <th>Emergency Contact Name</th>
                                    <th>Emergency Contact Phone</th> -->
                                </tr>
                            </thead>
                            <tbody v-for="(pool_session, index) in sessions" :key="index">
                                <tr :class="{'stripe-list': index % 2 === 0 }">
                                    <td>
                                        <div v-for="attendance in pool_session.filtered_attendances" :key="attendance.id">
                                            {{ attendance.swimmer.firstName || attendance.swimmer.first_name }} {{ attendance.swimmer.lastName || attendance.swimmer.last_name }}
                                        </div>
                                    </td>
                                    <td>
                                        <div v-for="attendance in pool_session.filtered_attendances" :key="attendance.id">
                                            {{ attendance.swimmer.phone }}
                                        </div>
                                    </td>
                                    <td>{{ pool_session.filtered_attendances.length }}</td>
                                    <td>{{ pool_session.start | readableDateTime }} - {{ pool_session.end | readableTime }}</td>
                                    <!-- <td>{{swimmer.birthDate || swimmer.birth_date | yearsOld }}</td>
                                    <td>{{swimmer.birthDate | moment("MM/DD/YY")}}</td>
                                    <td>{{swimmer.email}}</td>
                                    <td>{{swimmer.emergencyName}}</td>
                                    <td>{{swimmer.emergencyPhone}}</td> -->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment'
    export default {
        name: "realhab-attendance",
        props: [
            'sessions',
            'swimmers'
        ],
        data() {
            return {
                lesson_type: 'group',
                urlParams: new URLSearchParams(window.location.search),
                week: ''
            }
        },
        filters: {
            yearsOld: function (value) {
                return moment().diff(value, 'year');
            },
            readableDateTime: function (value) {
                return moment(value).format('MM/DD h:mm a');
            },
            readableTime: function (value) {
                return moment(value).format('h:mm a');
            }
        },
        created() {
            // Get the lesson_type from the url query string
            if (!this.urlParams.has('type')) {
                this.urlParams.set('type', this.lesson_type);
                window.history.replaceState({}, '', `${location.pathname}?${this.urlParams}`);
                // reload the page
                location.reload();
            }

            if (this.urlParams.has('type')) {
                this.lesson_type = this.urlParams.get('type');
            }

            // Get the week from the url query string
            if (this.urlParams.has('start') && this.urlParams.has('end')) {
                let start = this.urlParams.get('start');
                this.week = `${moment(start).format('YYYY')}-W${moment(start).week()}`;
            }
        },
        methods: {
            lessonTypeChanged() {
                // Update the url query string
                this.urlParams.set('type', this.lesson_type);
                window.history.replaceState({}, '', `${location.pathname}?${this.urlParams}`);
                // reload the page
                location.reload();
            },
            weekChanged() {
                // Update the url query string
                // Get the start and end date form the week
                let [year, week] = this.week.split('-W');
                let startDate = moment().year(year).week(week).startOf('isoWeek').format('YYYY-MM-DD');
                let endDate = moment().year(year).week(week).endOf('isoWeek').format('YYYY-MM-DD');
                this.urlParams.set('start', startDate);
                this.urlParams.set('end', endDate);
                window.history.replaceState({}, '', `${location.pathname}?${this.urlParams}`);
                // reload the page
                location.reload();
            }
        }
    }
</script>

<style scoped>
    .stripe-list{
        background: #F4F4F6;
    }
</style>
