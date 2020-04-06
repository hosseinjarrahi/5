require('./bootstrap');

window.Vue = require('vue');
import store from './store/store';
////////////////////////////////////////////////
Vue.component('app-menu',require('./components/AppMenu.vue').default);
Vue.component('app-bar',require('./components/AppBar.vue').default);
Vue.component('app-load',require('./components/AppLoad.vue').default);
Vue.component('app-product-table',require('./components/AppProductTable.vue').default);
////////////////////////////////////////////////
import VueMathjax from 'vue-mathjax';
Vue.use(VueMathjax);

import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
Vue.use(Vuetify)
const opts = {
    rtl:true
}
var vuetify = new Vuetify(opts);
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
        vuetify,
        store,
        mounted(){
            this.$store.state.load = false;
        }
    });

};

init()