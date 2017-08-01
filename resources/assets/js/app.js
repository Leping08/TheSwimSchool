
require('./bootstrap');

Vue.component('search', require('./components/Search.vue'));

const app = new Vue({
     el: '#search'
});
