require('./bootstrap');

window.Vue = require('vue');
import store from './store/store';
///////////////////////////////////////////////
import persianDatePicker from 'vue-persian-datetime-picker';
Vue.component('date-picker', persianDatePicker);
////////////////////////////////////////////////
const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
////////////////////////////////////////////////
import VueMathjax from 'vue-mathjax';
Vue.use(VueMathjax);
////////////
window.EventBus = new Vue({});
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
    const app = new Vue({
        el: '#app',
        store,
        mounted(){
            this.$store.state.load = false;
        }
    });

};

init()
