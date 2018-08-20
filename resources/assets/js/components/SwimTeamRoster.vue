<template>
    <div>
        <div class="uk-flex-middle uk-grid-margin uk-grid" uk-grid="">
            <div class="uk-width-1-1@m uk-first-column">
                <div class="uk-width-1-1@m uk-align-right uk-first-column">
                    <select v-model="selectedSeasonID" class="uk-select">
                        <option v-for="(season, index) in seasons" :key="season.id" :value="season.id">{{season.name}}</option>
                    </select>
                </div>
            </div>
            <div class="uk-width-1-1@m uk-first-column">
                <div v-for="(level, index) in levels" :key="level.id" class="uk-margin-bottom">
                    <h2 class="uk-heading-line">
                        <span>
                            {{level.name}} <!--TODO: Add total here-->
                        </span>
                    </h2>
                    <div class="uk-overflow-auto">
                        <table class="uk-table uk-table-striped uk-table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Date Of Birth</th>
                                    <th>Years Old</th>
                                    <th>Email</th>
                                    <th>Emergency Contact Name</th>
                                    <th>Emergency Contact Phone</th>
                                </tr>
                            </thead>
                            <tbody v-for="(swimmer, index) in level.swimmers" :key="swimmer.id">
                                <tr v-if="swimmer.season.id === selectedSeasonID">
                                    <td>{{swimmer.firstName}} {{swimmer.lastName}}</td>
                                    <td>{{swimmer.phone}}</td>
                                    <td>{{swimmer.birthDate | moment("MM/DD/YY")}}</td>
                                    <td>{{swimmer.birthDate | yearsOld }}</td>
                                    <td>{{swimmer.email}}</td>
                                    <td>{{swimmer.emergencyName}}</td>
                                    <td>{{swimmer.emergencyPhone}}</td>
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
        name: "swim-team-roster",
        props: [
            'seasons',
            'levels'
        ],
        data: function () {
            return {
                selectedSeasonID: 2
            }
        },
        filters: {
            yearsOld: function (value) {
                return moment().diff(value, 'year');
            }
        }
    }
</script>

<style scoped>

</style>