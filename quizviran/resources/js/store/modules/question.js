const state = () => ({
  questionErrors: []
});

const getters = {
};

const mutations = {
  setQuestionErrors(state, payload) {
    state.questionErrors = payload;
  }
};

const actions = {
  createQuestion({commit, dispatch}, payload) {
    commit('loadOn');
    axios.post('/quiz/question', payload)
      .then(({data}) => {
        dispatch('successAlert');
      })
      .catch(({response}) => {
        dispatch('errorAlert');
        commit('setQuestionErrors', response.data.errors)
      })
      .finally(() => {
        commit('loadOff');
      });
  }
};

export default {
  state,
  getters,
  mutations,
  actions
}
