const state = () => ({
  questionErrors: [],
  userQuestions: [],
  examQuestions: [],
});

const getters = {
  questionsHasNoCategory(state) {
    return state.userQuestions.filter(question => {
      return !!question.categories[0];
    });
  },
  examQuestions(state){
    return state.examQuestions;
  }
};

const mutations = {
  setQuestionErrors(state, payload) {
    state.questionErrors = payload;
  },
  setExamQuestions(state, payload) {
    state.examQuestions = payload;
  },
  setUserQuestions(state, payload) {
    state.userQuestions = payload;
  },
  pushToExamQuestions(state, payload) {
    state.examQuestions.push(payload);
  },
  pushToUserQuestions(state, payload) {
    state.userQuestions.push(payload);
  },
  deleteFromExamQuestion(state, payload) {
    state.examQuestions = state.examQuestions.filter(val => payload.indexOf(val.id) === -1);
  }
};

const actions = {
  AddQuestionToExam({commit, dispatch}, payload) {
    commit('loadOn');
    axios.post('/quiz/question/add-many-to-exam?exam=' + payload.id, {
      questions: payload.selected
    })
      .then(({data}) => {
        dispatch('successAlert');
      })
      .catch(({response}) => {
        dispatch('errorAlert');
      })
      .finally(() => {
        commit('loadOff');
      });
  },
  removeQuestionFromExam({commit, dispatch}, payload) {
    commit('loadOn');
    axios.post('/quiz/question/delete-many-from-exam?exam=' + this.id, {
      questions: payload
    })
      .then(res => {
        dispatch('successAlert');
        commit('deleteFromExamQuestion', payload);
      })
      .catch(err => {
        dispatch('errorAlert');
      })
      .finally(() => {
        commit('loadOff');
      });
  },
  
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
