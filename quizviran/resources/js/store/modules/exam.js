const state = () => ({
  exams: [],
  editingExam: false
});

const getters = {
  exams(state) {
    return state.exams;
  },
  editingExam(state) {
    return state.editingExam;
  }
};

const mutations = {
  setExams(state, payload) {
    state.exams = payload;
  },
  toggleShow(state, payload) {
    state.exams[payload].show = !state.exams[payload].show;
  },
  pushToExams(state, payload) {
    state.exams.unshift(payload);
  },
  resetEditExam(state) {
    state.editingExam = false;
  },
  setEditingExam(state, payload) {
    state.editingExam = payload;
  }
};

const actions = {
  switchToEditExam({dispatch, commit}, payload) {
    payload.start = payload.startForEdit;
    commit('setEditingExam', payload);
  },
  
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
  },
  
  createExam({dispatch, commit}, payload) {
    commit('loadOn');
    axios.post('/quiz/exam', {room: payload.room, ...payload.quiz})
      .then(response => {
        dispatch('successAlert');
        commit('pushToExams', response.data.exam)
      })
      .catch(error => {
        dispatch('errorAlert');
      })
      .then(() => {
        commit('loadOff');
      });
  },
  
  editExam({dispatch, commit}, payload) {
    commit('setEditingExam', payload);
  },
  
  updateExam({dispatch, commit, state}, payload) {
    commit('loadOn');
    axios.put(state.editingExam.link, payload)
      .then(response => {
        commit('successAlert', res.data.message);
      })
      .catch(error => {
        dispatch('errorAlert');
      })
      .finally(() => {
        commit('loadOff');
      });
  },
};

export default {
  state,
  getters,
  mutations,
  actions
}
