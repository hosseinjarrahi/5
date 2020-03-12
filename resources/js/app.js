/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('app-header', require('./components/AppHeader.vue').default);
Vue.component('app-taklif', require('./components/AppTaklif.vue').default);
Vue.component('app-taklif-card', require('./components/AppTaklifCard.vue').default);
Vue.component('app-count-down', require('./components/AppCountDown.vue').default);
Vue.component('app-quiz', require('./components/AppQuiz.vue').default);
Vue.component('app-quiz-card', require('./components/AppQuizCard.vue').default);
Vue.component('app-exam-card', require('./components/AppExamCard.vue').default);
Vue.component('app-exam', require('./components/AppExam.vue').default);
Vue.component('app-footer', require('./components/AppFooter.vue').default);
Vue.component('app-modal', require('./components/AppModal.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
