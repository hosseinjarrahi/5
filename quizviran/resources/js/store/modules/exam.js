const state = () => ({
  exams: []
});

const getters = {
  exams(state) {
    return state.exams;
  }
};

const mutations = {
  setExams(state, payload) {
    state.exams = payload;
  },
  toggleShow(state, payload) {
    state.exams[payload].show = !state.exams[payload].show;
  }
};

const actions = {
  revival({dispatch, commit}, payload) {
    commit('loadOn');
    axios.post(payload.exam.revivalLink, {sub: payload.sub})
      .then(response => {
        dispatch('successAlert');
      })
      .catch(error => {
        dispatch('errorAlert');
      })
      .then(() => {
        commit('loadOff');
      });
  },
  toggleShowExam({dispatch, commit}, payload) {
    commit('loadOn');
    axios.delete(payload.exam.deleteLink)
      .then(response => {
        dispatch('successAlert');
        commit('toggleShow', payload.index);
      })
      .catch(error => {
        dispatch('errorAlert');
      })
      .finally(() => {
        commit('loadOff');
      })
  }
};

export default {
  state,
  getters,
  mutations,
  actions
}
