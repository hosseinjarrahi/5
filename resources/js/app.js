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
Vue.component('app-login-modal', require('./components/AppLoginModal.vue').default);
Vue.component('app-loading', require('./components/AppLoading.vue').default);
Vue.component('app-quiz-make', require('./components/admin/AppQuizMake.vue').default);
Vue.component('app-latex', require('./components/admin/AppLatex.vue').default);
Vue.component('date-picker', persianDatePicker);

//main
Vue.component('app-slider', require('./components/main/AppSlider.vue').default);
Vue.component('app-course', require('./components/main/AppCourse.vue').default);
Vue.component('app-course-card', require('./components/main/AppCourseCard.vue').default);
Vue.component('app-categories', require('./components/main/AppCategories.vue').default);
Vue.component('app-product-desc', require('./components/main/AppProductDesc.vue').default);
Vue.component('app-title', require('./components/main/AppTitle.vue').default);
Vue.component('app-product-course-item', require('./components/main/AppProductCourseItem.vue').default);
Vue.component('app-content-border-box', require('./components/main/AppContentBorderBox.vue').default);
Vue.component('app-comments', require('./components/main/AppComments.vue').default);
Vue.component('app-comment-dialog', require('./components/main/AppCommentDialog.vue').default);
Vue.component('app-search-box', require('./components/main/AppSearchBox.vue').default);
Vue.component('app-bio', require('./components/main/AppBio.vue').default);
Vue.component('app-download-box', require('./components/main/AppDownloadBox.vue').default);
Vue.component('app-buy-modal', require('./components/main/AppBuyModal.vue').default);
Vue.component('app-modal', require('./components/AppModal.vue').default);
Vue.component('app-tag', require('./components/AppTag.vue').default);
Vue.component('app-error-list', require('./components/AppErrorList.vue').default);
Vue.component('app-event', require('./components/AppEvent.vue').default);
Vue.component('app-notification-box', require('./components/main/AppNotificationBox.vue').default);
Vue.component('app-profile-header', require('./components/main/AppProfileHeader.vue').default);
Vue.component('app-profile-form', require('./components/main/AppProfileForm.vue').default);


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
        el: '#app',
        mounted(){
            document.getElementById('pageLoader').classList.remove('d-flex');
            document.getElementById('pageLoader').classList.add('d-none');
        }
    });

};

init()