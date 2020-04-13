require('./bootstrap');

window.Vue = require('vue');
import store from './store/store';
///////////////////////////////////////////////
import persianDatePicker from 'vue-persian-datetime-picker';
Vue.component('date-picker', persianDatePicker);
////////////////////////////////////////////////
Vue.component('app-header',require('./components/AppHeader.vue').default);
Vue.component('app-footer',require('./components/AppFooter.vue').default);
Vue.component('app-loading',require('./components/AppLoading.vue').default);
Vue.component('app-modal',require('./components/AppModal.vue').default);
Vue.component('app-login-modal',require('./components/AppLoginModal.vue').default);
Vue.component('app-main-box',require('./components/AppMainBox.vue').default);
Vue.component('app-main-box-last-quiz',require('./components/AppMainBoxLastQuiz.vue').default);
Vue.component('app-under-hand',require('./components/AppUnderHand.vue').default);
Vue.component('app-best-users-item',require('./components/AppBestUsersItem.vue').default);
Vue.component('app-main-box-last-classes',require('./components/AppMainBoxLastClasses.vue').default);
Vue.component('app-event',require('./components/AppEvent.vue').default);
Vue.component('app-count-down',require('./components/AppCountDown.vue').default);
Vue.component('app-exam',require('./components/AppExam.vue').default);
Vue.component('app-exam-card',require('./components/AppExamCard.vue').default);
////////////////////////////////////////////////
import VueMathjax from 'vue-mathjax';
Vue.use(VueMathjax);
Vue.component('app-latex', require('./components/AppLatex.vue').default);
////////////
window.EventBus = new Vue({});
import globalMixin from './globalMixin';
//////////////
function checkAuth(){
    return axios.post('/check-auth')
        .then(res => res.data)
        .catch(err => console.log(err));
}
///////////////

function redirect(url){
    window.location = url;
};
async function init(){
    window.EventBus.auth = await checkAuth();
    Vue.mixin(globalMixin);
    const app = new Vue({
        el: '#app',
        store,
        mounted(){
            document.getElementById('pageLoader').classList.remove('d-flex');
            document.getElementById('pageLoader').classList.add('d-none');
        }
    });

};

init()