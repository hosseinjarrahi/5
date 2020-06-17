<template>
  <div class="row align-items-center justify-content-around">

    <div class="col-12 col-lg-6">
      <div class="p-2">
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-prepend"><span class="bg-dark-gray border border-light p-1 rounded left-horizon">موضوع</span></div>
            <input type="text" class="right-horizon form-control" v-model="name">
          </div>
        </div>
        <button @click="addCategory" class="btn btn-primary btn-block btn-sm">
          <span class="fas fa-plus mx-2"></span><span>افزودن</span>
        </button>
      </div>
    </div>

    <div class="horizon align-self-stretch d-none d-lg-inline-block"></div>
    <div class="divider d-lg-none d-inline-block my-2"></div>

    <div class="col-12 col-lg-5 d-flex flex-column align-items-center justify-content-center text-center">

      <div
        v-for="category in cats" :key="'category-' + category.id"
        class="my-1 d-flex p-1 rounded flex-row align-items-center justify-content-between bg-gray w-100">
        <span class="dots">{{ category.name }}</span>
        <div>
          <a @click="openEditForm(category)" class="btn btn-sm btn-primary rounded "><span class="fas fa-edit fa-fw"></span></a>
          <a @click="openDeleteForm(category)" class="btn btn-sm btn-danger rounded "><span class="fas fa-trash fa-fw"></span></a>
        </div>
      </div>

      <div class="d-flex flex-column" v-if="!cats.length">
        <span class="my-2 fas fa-swatchbook fa-3x"></span>
        <span>تاکنون دسته بندی ایجاد نکرده اید.</span>
      </div>

    </div>

    <transition mode="out-in" name="fade">
      <app-modal v-if="openEditModal" @close="openEditModal = false" title="ویرایش موضوع">
        <div class="p-2">
          <div class="form-group">
            <label>موضوع:</label>
            <input type="text" name="name" class="form-control" v-model="editName">
          </div>
          <button @click="updateCategory" class="btn btn-primary btn-sm">
            <span class="fas fa-edit mx-2"></span><span>ویرایش</span>
          </button>
        </div>
      </app-modal>
    </transition>

    <transition mode="out-in" name="fade">
      <app-modal v-if="openDeleteModal" @close="openDeleteModal = false" title="حذف موضوع">
        <div class="p-2">
          <div class="form-group">
            <span>آیا از حذف موضوع</span>
            <span class="bg-dark-gray px-2 py-0 rounded">{{ deleteCategory.name }}</span>
            <span>اطمینان دارید؟</span>
          </div>
          <button @click="destroyCategory" class="btn btn-danger mx-1 btn-sm">
            <span class="fas fa-check-circle mr-2"></span><span>بله</span>
          </button>
          <button @click="openDeleteModal = false" class="btn btn-primary mx-1 btn-sm">
            <span class="fas fa-times-circle mr-2"></span><span>خیر</span>
          </button>
        </div>
      </app-modal>
    </transition>

  </div>
</template>

<script>

  import {mapActions, mapMutations} from "vuex";

  export default {
    name: "AppQuestionCategoryTab",
    props: {
      categories: {default: []},
      route: {default: '/'}
    },
    data() {
      return {
        cats: Object.assign(this.categories),
        openEditModal: false,
        openDeleteModal: false,
        editCategory: null,
        deleteCategory: null,
        name: '',
        editName: ''
      }
    },
    methods: {
      ...mapActions(['successAlert', 'errorAlert']),
      ...mapMutations(['loadOn', 'loadOff', 'reload']),
      openEditForm(category) {
        this.openEditModal = true;
        this.editCategory = category;
        this.editName = category.name;
      },
      openDeleteForm(category) {
        this.openDeleteModal = true;
        this.deleteCategory = category;
      },
      destroyCategory() {
        this.loadOn();
        axios.delete(this.route + `/${this.deleteCategory.id}`)
          .then(response => {
            this.successAlert();
            this.cats.forEach((val, index) => {
              if (val.id == this.deleteCategory.id) {
                this.cats.splice(index, 1);
              }
            });
            this.reload();
          })
          .catch(error => {
            this.errorAlert();
          })
          .finally(() => {
            this.loadOff();
            this.openDeleteModal = false;
          });
      },
      updateCategory() {
        if (this.editName == '')
          return;

        this.loadOn();
        axios.patch(this.route + `/${this.editCategory.id}`, {name: this.editName})
          .then(response => {
            this.successAlert();
            this.cats.forEach((val, index) => {
              if (val.id == this.editCategory.id) {
                this.cats[index].name = this.editName;
              }
            });
            this.reload();
          })
          .catch(error => {
            this.errorAlert();
          })
          .finally(() => {
            this.loadOff();
            this.openEditModal = false;
          });
      },
      addCategory() {
        if (this.name == '')
          return;

        this.loadOn();
        axios.post(this.route, {name: this.name})
          .then(response => {
            this.successAlert();
            this.cats.push(response.data.category);
            this.name = '';
            this.reload();
          })
          .catch(error => {
            this.errorAlert();
          })
          .finally(() => {
            this.loadOff();
          });
      }
    }
  }
</script>

<style scoped>
  .dots {
    text-overflow: ellipsis;
    max-width: 120px;
    overflow: hidden;
    white-space: nowrap;
  }
</style>
