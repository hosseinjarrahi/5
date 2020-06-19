const state = () => ({
  deleteModal: false,
  commentForDelete: false
})

const getters = {
  deleteModal(state) {
    return state.deleteModal;
  }
}

const mutations = {
  toggleDeleteModal(state, payload = false) {
    state.commentForDelete = payload;
    state.deleteModal = !state.deleteModal;
  }
}

const actions = {
  updateComment({commit, dispatch}, payload) {
    commit('loadOn');
    axios.put(payload.updateLink, {comment: payload.comment})
      .then(response => {
        dispatch('successAlert');
      })
      .catch(error => {
        dispatch('errorAlert');
      })
      .then(() => {
        commit('loadOff');
        this.editing = false;
      });
  },
  
  deleteComment({commit, dispatch, state}) {
    commit('loadOn');
    axios.delete(state.commentForDelete.deleteLink)
      .then(response => {
        dispatch('successAlert', response.data.message);
        commit('removeFromComments', state.commentForDelete);
        commit('toggleDeleteModal');
      })
      .catch(({response}) => {
        dispatch('errorAlert', response.data.message);
      })
      .then(() => {
        commit('loadOff');
      });
  },
  
  deleteCommentFile({commit, dispatch}, id) {
    this.comment.files = this.comment.files.filter(val => {
      return val.id != id
    });
    axios.delete('/file/' + id)
      .then(res => console.log(res))
      .catch(err => console.log(err));
  },
  
}

export default {
  state,
  getters,
  mutations,
  actions
}
