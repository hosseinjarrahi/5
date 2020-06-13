import Swal from "sweetalert2";

const state = () => ({
  topMenu: false,
  load: false,
  loadComplete: null,
  userMenu: false,
  loginModal: false,
  
});

const getters = {
  loginModal(state) {
    return state.loginModal;
  },
  
  userMenu(state) {
    return state.userMenu;
  },
  
  topMenu(state) {
    return state.topMenu;
  },
  
  load(state) {
    return state.load;
  },
  
  loadComplete(state) {
    return state.loadComplete;
  },
};

const mutations = {
  toggleLoginModal(state) {
    state.loginModal = !state.loginModal;
  },
  toggleUserMenu(state) {
    state.userMenu = !state.userMenu;
  },
  toggleTopMenu(state) {
    state.topMenu = !state.topMenu;
  },
  loadOff(state, payload) {
    state.load = false;
    state.loadComplete = payload < 100 ? payload : null;
  },
  loadOn(state) {
    state.load = true;
  }
};

const actions = {
  sweetAlert({commit}, payload) {
    return Swal.fire({
      text: payload.text,
      icon: payload.icon,
      confirmButtonText: "بسیار خوب",
      timer: 5000
    });
  },
  successAlert({dispatch}, payload = 'با موفقیت انجام شد') {
    return dispatch('sweetAlert', {text: payload, icon: 'success'});
  },
  errorAlert({dispatch}, payload = 'مشکلی رخ داده است') {
    return dispatch('sweetAlert', {text: payload, icon: 'error'});
  },
  reload(context, timer = 0) {
    return setTimeout(() => window.location.reload(), timer);
  },
  redirect(context, payload = {url: '', timer: 0}) {
    return setTimeout(() => {
      window.location = payload.url;
    }, payload.timer);
  },
};

export default {
  state,
  getters,
  mutations,
  actions
}
