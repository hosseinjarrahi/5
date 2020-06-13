const state = () => ({
  auth: false,
  registerErrors: [],
  status: {
    login: true,
    register: false,
    recovery: false,
    registerCode: false,
    recoveryCode: false,
  },
});

const getters = {
  
  registerErrors(state) {
    return state.registerErrors;
  },
  
  status(state) {
    return state.status;
  },
  
  auth(state) {
    return state.auth;
  }
  
};

const mutations = {
  
  resetRegisterForm(state) {
    state.registerForm = {phone: "", name: "", type: "", password: "", confirm: ""};
  },
  
  setStatus(state, payload) {
    state.status[payload.prop] = payload.value;
  },
  
  setRegisterErrors(state, payload) {
    state.registerErrors = payload;
  },
  
};

const actions = {
  
  logout() {
    window.location = '/logout';
  },
  
  doLogin({commit, dispatch}, payload) {
    commit('loadOn', null);
    commit('setRegisterErrors', []);
    
    axios.post('/login', payload)
      .then(response => {
        dispatch('successAlert');
        dispatch('reload');
      })
      .catch(error => {
        commit('setRegisterErrors', error.response.data.errors);
        dispatch('errorAlert');
      })
      .finally(() => {
        commit('loadOff');
      });
  },
  
  doRegister({commit, dispatch},payload) {
    commit('loadOn', null);
    commit('setRegisterErrors', []);
    axios.post("/register", payload)
      .then(response => {
        dispatch('changeState', 'registerCode');
        commit('resetRegisterForm');
        dispatch('successAlert');
      })
      .catch(err => {
        commit('setRegisterErrors', error.response.data.errors);
        dispatch('errorAlert');
      })
      .finally(() => {
        commit('loadOff');
      });
  },
  
  verify({commit, dispatch}, payload) {
    commit('loadOn', null);
    commit('setRegisterErrors', []);
    axios.post("/verify", {verify: payload})
      .then(response => {
        dispatch('successAlert');
        dispatch('changeState', 'login');
        dispatch('reload', 1000);
      })
      .catch(err => {
        dispatch('errorAlert');
      })
      .finally(() => {
        commit('loadOff');
      });
  },
  
  sendCode({commit, dispatch}, payload) {
    if (!payload) return;
    commit('loadOn', null);
    commit('setRegisterErrors', []);
    axios.post('/reset-password', {phone: payload})
      .then(response => {
        dispatch('successAlert', 'اگر شماره تلفن و یا ایمیل را درست وارد کرده باشید کد برای شما ارسال شده است');
        commit('toggleLoginModal');
      })
      .catch(({response}) => {
        // commit('setRegisterErrors', response.data.message);
        dispatch('errorAlert');
      })
      .finally(() => {
        commit('loadOff');
      });
  },
  
  changeState({state, dispatch, commit}, payload) {
    commit('setRegisterErrors', []);
    for (const prop in state.status) {
      commit('setStatus', {prop: prop, value: (prop == payload) ? true : false});
    }
  }
  
};

export default {
  state,
  getters,
  mutations,
  actions
}
