require('./bootstrap');

window.Vue = require('vue');

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
Vue.component('app-loading', require('./components/AppLoading.vue').default);

window.EventBus = new Vue();

import globalMixin from './globalMixin';
Vue.mixin(globalMixin);

const app = new Vue({
    el: '#app',
});
