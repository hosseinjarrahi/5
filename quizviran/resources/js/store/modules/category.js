const state = () => ({
  userCategories:[],
  editCategoryModal:false,
  deleteCategoryModal:false,
});

const getters = {
  userCategories(state){
    return state.userCategories;
  },
  editCategoryModal(state){
    return state.editCategoryModal;
  },
  deleteCategoryModal(state){
    return state.deleteCategoryModal;
  }
};

const mutations = {
  toggleEditCategoryModal(state){
    state.editCategoryModal = !state.editCategoryModal;
  },
  toggleDeleteCategoryModal(state){
    state.deleteCategoryModal = !state.deleteCategoryModal;
  },
  setUserCategories(state,payload){
    state.userCategories = payload;
  },
  pushToUserCategories(state,payload){
    state.userCategories.push(payload);
  },
  deleteFromUserCategories(state,payload){
    state.userCategories.forEach((val, index) => {
      if (val.id == payload.id) {
        state.userCategories.splice(index, 1);
      }
    });
  },
  editUserCategory(state,payload){
    state.userCategories.forEach((val, index) => {
      if (val.id == payload.id) {
        state.userCategories[index].name = payload.editName;
      }
    });
  }
};

const actions = {
  
  createCategory({commit,dispatch},payload) {
    if (payload == '')
      return;
  
    commit('loadOn');
    axios.post('/quiz/panel/category' , {name: payload})
      .then(response => {
        dispatch('successAlert');
        commit('pushToUserCategories',response.data.category);
      })
      .catch(error => {
        dispatch('errorAlert');
      })
      .finally(() => {
        commit('loadOff');
      });
  },
  
  destroyCategory({commit,dispatch},payload) {
    commit('loadOn');
    axios.delete(payload.updateLink)
      .then(response => {
        dispatch('successAlert');
        commit('deleteFromUserCategories',payload);
      })
      .catch(error => {
        dispatch('errorAlert');
      })
      .finally(() => {
        commit('loadOff');
        commit('toggleDeleteCategoryModal');
      });
  },
  
  updateCategory({commit,dispatch},payload) {
    if (payload.editName == '')
      return;
    
    commit('loadOn');
    axios.patch(payload.category.updateLink, {name: payload.editName})
      .then(response => {
        dispatch('successAlert');
        commit('editUserCategory',{id:payload.category.id,editName:payload.editName});
        commit('toggleEditCategoryModal');
      })
      .catch(error => {
        dispatch('errorAlert');
      })
      .finally(() => {
        commit('loadOff');
        this.openEditModal = false;
      });
  },
};

export default {
  state,
  getters,
  mutations,
  actions
}
