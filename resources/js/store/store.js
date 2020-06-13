import Vue from 'vue';
import Vuex from 'vuex';
import common from './modules/shared/common';
import register from './modules/shared/register';

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    common,
    register
  }
});

