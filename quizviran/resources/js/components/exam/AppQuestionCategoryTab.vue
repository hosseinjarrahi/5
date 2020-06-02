<template>
  <div class="row align-items-center justify-content-around">

    <div class="col-12 col-lg-6">
      <div class="p-2">
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-prepend"><span class="bg-dark-gray   border border-light p-1 rounded left-horizon">موضوع</span></div>
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
        class="my-1 d-flex p-2 rounded flex-row align-items-center justify-content-between bg-gray w-100">
        <span>{{ category.name }}</span>
        <div>
          <a @click="openEditForm(category)" class="btn btn-sm rounded btn-primary"><span>ویرایش</span></a>
          <a @click="openDeleteForm(category)" class="btn btn-sm rounded btn-danger"><span>حذف</span></a>
        </div>
      </div>

      <div class="d-flex flex-column" v-if="!cats.length">
        <span class="my-2 fas fa-swatchbook fa-3x"></span>
        <span>تاکنون دسته بندی ایجاد نکرده اید.</span>
      </div>

    </div>

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

  </div>
</template>

<script>
    import Swal from 'sweetalert2';

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
                this.load();
                axios.delete(this.route + `/${this.deleteCategory.id}`)
                    .then(response => {
                        Swal.fire({
                            text: 'با موفقیت حذف شد.',
                            icon: 'success',
                            confirmButtonText: 'بسیار خوب',
                            timer: 5000,
                        });

                        this.cats.forEach((val, index) => {
                            if (val.id == this.deleteCategory.id) {
                                this.cats.splice(index, 1);
                            }
                        });

                    })
                    .catch(error => {
                        Swal.fire({
                            text: 'مشکلی در حذف رخ داده است.',
                            icon: 'error',
                            confirmButtonText: 'بسیار خوب',
                            timer: 5000,
                        });
                    })
                    .finally(() => {
                        this.closeLoad();
                        this.openDeleteModal = false;
                    });
            },
            updateCategory() {
                if (this.editName == '')
                    return;

                this.load();
                axios.patch(this.route + `/${this.editCategory.id}`, {name: this.editName})
                    .then(response => {
                        Swal.fire({
                            text: 'با موفقیت ویرایش شد.',
                            icon: 'success',
                            confirmButtonText: 'بسیار خوب',
                            timer: 5000,
                        });

                        this.cats.forEach((val, index) => {
                            if (val.id == this.editCategory.id) {
                                this.cats[index].name = this.editName;
                            }
                        });

                    })
                    .catch(error => {
                        console.log(error.response);
                        Swal.fire({
                            text: 'مشکلی در ویرایش رخ داده است.',
                            icon: 'error',
                            confirmButtonText: 'بسیار خوب',
                            timer: 5000,
                        });
                    })
                    .finally(() => {
                        this.closeLoad();
                        this.openEditModal = false;
                    });
            },
            addCategory() {
                if (this.name == '')
                    return;

                this.load();
                axios.post(this.route, {name: this.name})
                    .then(response => {
                        Swal.fire({
                            text: 'با موفقیت اضافه شد.',
                            icon: 'success',
                            confirmButtonText: 'بسیار خوب',
                            timer: 5000,
                        });

                        this.cats.push(response.data.category);
                        this.name = '';
                    })
                    .catch(error => {
                        Swal.fire({
                            text: 'مشکلی در افزودن رخ داده است.',
                            icon: 'error',
                            confirmButtonText: 'بسیار خوب',
                            timer: 5000,
                        });
                    })
                    .finally(() => {
                        this.closeLoad();
                    });
            }
        }
    }
</script>

<style scoped>

</style>
