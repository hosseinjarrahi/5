require('./bootstrap');
import init from './components/shared/helpers';

window.Vue = require('vue');
import store from './store/store';

import persianDatePicker from 'vue-persian-datetime-picker';
Vue.component('date-picker', persianDatePicker);

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

init(Vue,store);
