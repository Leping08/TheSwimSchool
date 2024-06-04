//Libraries
import Vue from 'vue';
import VueMoment from 'vue-moment'
import moment from 'moment'

//Components
//import privateLessonRequestForm from './components/PrivateLessonRequestForm.vue'
import swimTeamRoster from './components/SwimTeamRoster.vue'
import promo_code from './components/promoCode.vue'
import privateCalendar from './components/PrivateCalendar.vue'
import instructorCalendar from './components/InstructorCalendar.vue'
import emailEdit from './components/EmailEdit.vue'
import realhabAttendance from './components/RealhabAttendance.vue'

Vue.use(VueMoment, {
    moment,
});

new Vue({
    el: '#app',
    components: {
        swimTeamRoster,
        //privateLessonRequestForm,
        privateCalendar,
        instructorCalendar,
        promo_code: promo_code,
        emailEdit,
        realhabAttendance
    }
});
