require('./bootstrap');

window.Vue = require('vue');
import persianDatePicker from 'vue-persian-datetime-picker';

import VueMathjax from 'vue-mathjax';
Vue.use(VueMathjax);

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
Vue.component('app-quiz-make', require('./components/admin/AppQuizMake.vue').default);
Vue.component('app-latex', require('./components/admin/AppLatex.vue').default);
Vue.component('date-picker', persianDatePicker);

import globalMixin from './globalMixin';
window.EventBus = new Vue({});

function checkAuth(){
    return axios.post('/check-auth')
        .then(res => res.data)
        .catch(err => console.log(err));
}

async function init(){
    window.EventBus.auth = await checkAuth();
    Vue.mixin(globalMixin);
    const app = new Vue({
        el: '#app'
    });

};

init()