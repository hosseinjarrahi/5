<template>
  <div>
    <div class="form-group">
      <span class="fas fa-user"></span>
      <span>عنوان :</span>
      <input name="title" class="form-control">
    </div>
    <div class="form-group">
      <span class="fas fa-calendar"></span>
      <span>توضیحات :</span>
      <vue-editor name="desc" v-model="content"></vue-editor>
    </div>
    <div class="form-group">
      <span class="fas fa-question"></span>
      <span>وضعیت :</span>
      <input name="status" class="form-control">
    </div>
    <div class="form-group">
      <span class="fas fa-pen"></span>
      <span>درصد تکمیل :</span>
      <input name="percentage" class="form-control">
    </div>
    <div class="form-group">
      <span class="fas fa-pen"></span>
      <span>برچسب ها را با خط فاصله از هم جدا کنید:</span>
      <input name="tags" class="form-control">
    </div>
    <div class="form-group">
      <span class="fas fa-pen"></span>
      <span>کلمات کلیدی - موتور های جست و جو :</span>
      <input name="keywords" class="form-control">
    </div>
    <div class="form-group">
      <span class="fas fa-pen"></span>
      <span>عنوان صفحه :</span>
      <input name="pageTitle" class="form-control">
    </div>

    <div class="form-group">
      <span class="fas fa-pen"></span>
      <input type="checkbox" v-model="course">
      <span>میخواهم دوره ایجاد کنم</span>
    </div>


    <div v-if="course">
      <div class="btn btn-primary" @click="items++">افزودن آیتم</div>
      <div class="btn btn-primary" @click="items--" v-if="items>0">حذف آخرین آیتم</div>

      <div v-for="item in items" class="bg-dark text-white p-3 my-2 rounded">
        #{{ item }}

        <div class="form-group">
          <span class="fas fa-eye"></span>
          <span>عنوان :</span>
          <input :name="['course' + item]" class="form-control">
        </div>
        <div class="form-group">
          <span class="fas fa-eye"></span>
          <span>فایل :</span>
          <input type="file" :name="['course' + item]" class="form-control">
        </div>
        <div class="form-group">
          <span class="fas fa-eye"></span>
          <input type="checkbox" :name="['course' + item]">
          <span>رایگان</span>
        </div>
        <div class="form-group">
          <span class="fas fa-eye"></span>
          <input type="checkbox" :name="['course' + item]">
          <span>پیش نمایش</span>
        </div>

        <hr>
      </div>

    </div>

    <button class="btn btn-block btn-primary my-2">ارسال</button>
  </div>
</template>

<script>
    import {VueEditor} from "vue2-editor";

    export default {
        name: "AppProductForm",
        components: ['VueEditor'],
        data() {
            return {
                course: null,
                items: 0,
                content: ""
            }
        }
    }
</script>

<style scoped>

</style>