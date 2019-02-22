//require('./bootstrap');

//Libraries
import Vue from 'vue';
import VueMoment from 'vue-moment'
import moment from 'moment'

//Components
import search from './components/search'
import privateLessonRequestForm from './components/PrivateLessonRequestForm'
import swimTeamRoster from './components/SwimTeamRoster'

Vue.use(VueMoment, {
    moment,
});

const app = new Vue({
    el: '#app',
    components: {
        search,
        swimTeamRoster,
        privateLessonRequestForm
    }
});
