//require('./bootstrap');

//Libraries
import Vue from 'vue';
import VueMoment from 'vue-moment'
import moment from 'moment'

//Components
//import privateLessonRequestForm from './components/PrivateLessonRequestForm'
import swimTeamRoster from './components/SwimTeamRoster'
import promo_code from './components/promoCode'
import privateCalendar from './components/PrivateCalendar'
import instructorCalendar from './components/InstructorCalendar'

Vue.use(VueMoment, {
    moment,
});

const app = new Vue({
    el: '#app',
    components: {
        swimTeamRoster,
        //privateLessonRequestForm,
        privateCalendar,
        instructorCalendar,
        promo_code: promo_code
    }
});
