<template>
  <div>
    <div class="form-group">
      <span>عنوان :</span>
      <input name="title" class="form-control">
    </div>

    <div class="form-group">
      <span>توضیحات :</span>
      <vue-editor name="desc" v-model="content"></vue-editor>
    </div>

    <div class="form-group">
      <span>قیمت :</span>
      <input name="price" class="form-control">
    </div>

    <div class="form-group">
      <span>وضعیت :</span>
      <input name="status" class="form-control">
    </div>

    <div class="form-group">
      <span>درصد تکمیل :</span>
      <input name="percentage" class="form-control">
    </div>

    <div class="form-group">
      <span>برچسب ها را با خط فاصله از هم جدا کنید:</span>
      <input name="tags" class="form-control">
    </div>

    <div class="form-group">
      <span>کلمات کلیدی - موتور های جست و جو :</span>
      <input name="keywords" class="form-control">
    </div>

    <div class="form-group">
      <span>عنوان صفحه :</span>
      <input name="pageTitle" class="form-control">
    </div>

    <div class="form-group">
      <span>توضیحات صفحه :</span>
      <textarea name="pageDescription" class="form-control"></textarea>
    </div>

    <div class="form-group">
      <span>نخفیف :</span>
      <input name="offer" class="form-control">
    </div>

    <div class="form-group">
      <span>تصویر :</span>
      <input type="file" name="pic" class="form-control">
    </div>

    <div class="form-group">
      <input type="checkbox" v-model="course">
      <span>میخواهم دوره ایجاد کنم</span>
    </div>

    <div v-if="course">
      <div class="btn btn-primary" @click="items++">افزودن آیتم</div>
      <div class="btn btn-primary" @click="items--" v-if="items>0">حذف آخرین آیتم</div>

      <div v-for="item in items" class="bg-dark text-white p-3 my-2 rounded">
        #{{ item }}

        <div class="form-group">
          <span>عنوان :</span>
          <input :name="'courseTitle' + item" class="form-control">
        </div>
        <div class="form-group">
          <span>فایل :</span>
          <input type="file" :name="'courseFile' + item" class="form-control">
        </div>
        <div class="form-group">
          <input type="checkbox" :name="'courseFree' + item">
          <span>رایگان</span>
        </div>
        <div class="form-group">
          <input type="checkbox" :name="'courseDemo' + item">
          <span>پیش نمایش</span>
        </div>
        <hr>
      </div>

    </div>

    <input type="hidden" v-model="items" name="courseCount">
    <input type="hidden" v-model="fileCount" name="fileCount">


    <div class="form-group">
      <input type="checkbox" v-model="fileCount">
      <span>میخواهم فایل ایجاد کنم</span>
    </div>

    <div v-if="fileCount > 0">
      <div class="btn btn-primary" @click="fileCount++">افزودن آیتم</div>
      <div class="btn btn-primary" @click="fileCount--" v-if="fileCount>0">حذف آخرین آیتم</div>

      <div v-for="n in fileCount" class="bg-dark text-white p-3 my-2 rounded">
        #{{ n }}

        <div class="form-group">
          <span>فایل :</span>
          <input type="file" :name="'file' + n" class="form-control">
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
                content: "",
                fileCount:false
            }
        }
    }
</script>

<style scoped>

</style>