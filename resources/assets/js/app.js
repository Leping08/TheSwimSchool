
require('./bootstrap');

Vue.component('search', require('./components/Search.vue'));
//Vue.component('promo-code', require('./components/promoCode.vue'));


const app = new Vue({
     el: '#app'
});
