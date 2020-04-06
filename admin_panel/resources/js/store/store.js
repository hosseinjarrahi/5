import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

export default new Vuex.Store({
  state:{
    drawer:true,
    load:true
  },
  getters:{
    getDraw(state){
      return state.drawer;
    },
    load(state){
      return state.load;
    }
  },
  mutations:{
    toggleDrawer(state){
      state.drawer = !state.drawer;
    },
    loadOff(state){
      state.load = false;
    }
  },
  actions:{

  }
});