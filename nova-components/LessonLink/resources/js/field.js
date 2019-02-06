Nova.booting((Vue, router, store) => {
    Vue.component('index-lesson-link', require('./components/IndexField'))
    Vue.component('detail-lesson-link', require('./components/DetailField'))
    Vue.component('form-lesson-link', require('./components/FormField'))
})
