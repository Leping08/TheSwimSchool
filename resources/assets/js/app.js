//require('./bootstrap');

window.Vue = require('vue');

Vue.component('search', require('./components/Search.vue'));
Vue.component('swim-team-roster', require('./components/SwimTeamRoster.vue'));
//Vue.component('promo-code', require('./components/promoCode.vue'));

import VueMoment from 'vue-moment'
import moment from 'moment'

Vue.use(VueMoment, {
    moment,
});

const app = new Vue({
     el: '#app'
});
