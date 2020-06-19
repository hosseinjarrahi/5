const state = () => ({
  comments: [],
  files: []
});

const getters = {
  roomComments(state) {
    return state.comments;
  },
  files(state) {
    return state.files;
  }
};

const mutations = {
  setComments(state, payload) {
    state.comments = payload;
  },
  pushToComments(state, payload) {
    state.comments.unshift(payload);
  },
  removeFromComments(state, payload) {
    state.comments = state.comments.filter(val => {
      return val.id != payload.id
    });
  },
  setFiles(state, payload) {
    state.files = payload;
  },
  pushToFiles(state, payload) {
    state.files.unshift(payload);
  },
  removeFile(state, payload) {
    state.files = state.files.filter(val => {
      return val.id != payload
    });
  },
  resetGap(state) {
    state.files = [];
  }
};

const actions = {
  createRoomComment({dispatch, commit}, payload) {
    if (payload.comment == '')
      return;
    
    commit('loadOn');
    axios.post('/quiz/panel/room/comment', {
      files: payload.files,
      comment: payload.comment,
      type: payload.type,
      id: payload.id
    })
      .then(response => {
        dispatch('successAlert');
        console.log(response.data.comment);
        commit('pushToComments', response.data.comment);
        commit('resetGap');
      })
      .catch(error => {
        dispatch('errorAlert');
      })
      .finally(() => {
        commit('loadOff');
      });
  },
  uploadGapFile({dispatch, commit}, file) {
    let formData = new FormData();
    formData.append("file", file);
    
    axios.post("/file", formData, {
      headers: {"Content-Type": "multipart/form-data"},
      onUploadProgress: (progressEvent) => {
        commit('loadOn', parseInt((progressEvent.loaded / progressEvent.total) * 100));
      },
    })
      .then((response) => {
        dispatch('successAlert', response.data.message);
        commit('pushToFiles', response.data.file);
      })
      .catch((error) => {
        dispatch('errorAlert', error.response.data.errors.file || error.response.data.errors.max);
      })
      .finally(() => {
        commit('loadOff');
      });
  },
  deleteGapFile({commit, dispatch}, id) {
    commit('removeFile', id);
    axios.delete('/file/' + id)
      .then(response => console.log(response))
      .catch(error => console.log(error));
  },
};

export default {
  state,
  getters,
  mutations,
  actions
}
