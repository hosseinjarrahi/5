require('./bootstrap');
import init from './components/shared/helpers';

window.Vue = require('vue');

import persianDatePicker from 'vue-persian-datetime-picker';
Vue.component('date-picker', persianDatePicker);

import VueMathjax from 'vue-mathjax';
Vue.use(VueMathjax);

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import globalMixin from './globalMixin';

init(Vue,globalMixin);
