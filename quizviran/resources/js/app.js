require('./bootstrap');

window.Vue = require('vue');
import store from './store/store';
///////////////////////////////////////////////
import persianDatePicker from 'vue-persian-datetime-picker';
Vue.component('date-picker', persianDatePicker);
///////////////////////////////////////////////
const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
///////////////////////////////////////////////
import VueMathjax from 'vue-mathjax';
Vue.use(VueMathjax);
Vue.component('app-latex', require('./components/AppLatex.vue').default);
///////////////////////////////////////////////
window.EventBus = new Vue({});
import globalMixin from './globalMixin';
///////////////////////////////////////////////
function checkAuth(){
    return axios.post('/check-auth')
        .then(res => res.data)
        .catch(err => console.log(err));
}
///////////////////////////////////////////////
function redirect(url){
    window.location = url;
};
async function init(){
    window.EventBus.auth = await checkAuth();
    Vue.mixin(globalMixin);
    const app = new Vue({
        el: '#app',
        store,
        data(){
          return {
              EventBus
          }
        },
        mounted(){
            document.getElementById('pageLoader').classList.remove('d-flex');
            document.getElementById('pageLoader').classList.add('d-none');
        }
    });

};

init()
