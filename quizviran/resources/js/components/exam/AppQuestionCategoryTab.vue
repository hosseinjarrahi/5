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
        <button @click="createCategory(name)" class="btn btn-primary btn-block btn-sm">
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
      <app-modal v-if="openEditModal" @close="toggleEditCategoryModal" title="ویرایش موضوع">
        <div class="p-2">
          <div class="form-group">
            <label>موضوع:</label>
            <input type="text" name="name" class="form-control" v-model="editName">
          </div>
          <button @click="updateCategory({editName:editName,category:editCategory})" class="btn btn-primary btn-sm">
            <span class="fas fa-edit mx-2"></span><span>ویرایش</span>
          </button>
        </div>
      </app-modal>
    </transition>

    <transition mode="out-in" name="fade">
      <app-modal v-if="openDeleteModal" @close="toggleDeleteCategoryModal" title="حذف موضوع">
        <div class="p-2">
          <div class="form-group">
            <span>آیا از حذف موضوع</span>
            <span class="bg-dark-gray px-2 py-0 rounded">{{ deleteCategory.name }}</span>
            <span>اطمینان دارید؟</span>
          </div>
          <button @click="destroyCategory(deleteCategory)" class="btn btn-danger mx-1 btn-sm">
            <span class="fas fa-check-circle mr-2"></span><span>بله</span>
          </button>
          <button @click="toggleDeleteCategoryModal" class="btn btn-primary mx-1 btn-sm">
            <span class="fas fa-times-circle mr-2"></span><span>خیر</span>
          </button>
        </div>
      </app-modal>
    </transition>

  </div>
</template>

<script>

  import {mapActions, mapMutations, mapGetters} from "vuex";

  export default {
    name: "AppQuestionCategoryTab",

    data() {
      return {
        editCategory: null,
        deleteCategory: null,
        name: '',
        editName: ''
      }
    },

    methods: {
      ...mapActions(['destroyCategory','createCategory','updateCategory']),
      ...mapMutations(['toggleEditCategoryModal', 'toggleDeleteCategoryModal']),

      openEditForm(category) {
        this.toggleEditCategoryModal();
        this.editCategory = category;
        this.editName = category.name;
      },

      openDeleteForm(category) {
        this.toggleDeleteCategoryModal();
        this.deleteCategory = category;
      },
    },

    computed: {
      ...mapGetters({
        openEditModal: 'editCategoryModal',
        openDeleteModal: 'deleteCategoryModal',
        cats: 'userCategories',
      })
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
