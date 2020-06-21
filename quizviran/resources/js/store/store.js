import Vue from 'vue';
import Vuex from 'vuex';
import common from './modules/shared/common';
import register from './modules/shared/register';
import exam from './modules/exam';
import room from './modules/room';
import comment from './modules/comment';
import question from './modules/question';
import category from './modules/category';

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    common,
    register,
    exam,
    comment,
    room,
    question,
    category,
  }
});
