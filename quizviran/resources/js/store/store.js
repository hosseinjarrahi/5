import Vue from 'vue';
import Vuex from 'vuex';
import common from './modules/shared/common';
import register from './modules/shared/register';
import exam from './modules/exam';
import room from './modules/room';

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    common,
    register,
    exam,
    room,
  }
});
