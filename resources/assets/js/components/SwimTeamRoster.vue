<template>
    <div>
        <div class="uk-flex-middle uk-grid-margin uk-grid" uk-grid="">
            <div class="uk-width-1-1@m uk-first-column">
                <div class="uk-width-1-1@m uk-align-right uk-first-column">
                    <div class="uk-h2">
                        Select Season
                    </div>
                    <select v-model="selectedSeasonId" class="uk-select">
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
                        <table class="uk-table uk-table-hover uk-table-divider">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Date Of Birth</th>
                                    <th>Years Old</th>
                                    <th>Email</th>
                                    <th>Shirt Size</th>
                                    <th>Emergency Contact Name</th>
                                    <th>Emergency Contact Phone</th>
                                </tr>
                            </thead>
                            <tbody v-for="(swimmer, index) in level.swimmers" :key="swimmer.id">
                                <tr v-if="swimmer.season.id === selectedSeasonId" :class="{'stripe-list': index % 2 === 0 }">
                                    <td>{{swimmer.firstName}} {{swimmer.lastName}}</td>
                                    <td>{{swimmer.phone}}</td>
                                    <td>{{swimmer.birthDate | moment("MM/DD/YY")}}</td>
                                    <td>{{swimmer.birthDate | yearsOld }}</td>
                                    <td>{{swimmer.email}}</td>
                                    <td>
                                        <template v-if="swimmer.shirt_size">
                                            {{swimmer.shirt_size.size}}
                                        </template>
                                        <template v-else>
                                            --
                                        </template>
                                    </td>
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
            'levels',
            'currentseason'
        ],
        data: function () {
            return {
                selectedSeasonId: 0
            }
        },
        filters: {
            yearsOld: function (value) {
                return moment().diff(value, 'year');
            }
        },
        created() {
            this.selectedSeasonId = this.currentseason[0].id
        }
    }
</script>

<style scoped>
    .stripe-list{
        background: #F4F4F6;
    }
</style>