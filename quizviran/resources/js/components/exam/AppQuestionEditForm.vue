<template>
  <div class="p-2 w-100">
    <div class="form-group">
      <select name="type" v-model="q.type" class="form-control">
        <option value="test">تستی</option>
        <!--        <option value="descriptive">تشریحی</option>-->
      </select>
    </div>
    <div class="form-group">
      <label><span class="fas fa-paragraph"></span>توضیحات</label>

      <textarea id="editor"
                :class="['form-control', { 'is-invalid' : errors.desc && !q.desc.length } ]"
                cols="30"
                rows="10"
      >
      </textarea>

      <app-errors :errors="errors.desc">وارد کردن توضیحات الزامی است</app-errors>

    </div>

    <div class="form-group">
      <label><span class="fas fa-check-square"></span> گزینه A </label>
      <input class="form-control" v-model="q.A">
    </div>

    <div class="form-group">
      <label><span class="fas fa-check-square"></span> گزینه B </label>
      <input class="form-control" v-model="q.B">
    </div>

    <div class="form-group">
      <label><span class="fas fa-check-square"></span> گزینه C </label>
      <input class="form-control" v-model="q.C">
    </div>

    <div class="form-group">
      <label><span class="fas fa-check-square"></span> گزینه D </label>
      <input class="form-control" v-model="q.D">
    </div>

    <div class="form-group">
      <label><span class="fas fa-star"></span> امتیاز سوال </label>
      <input required type="number" class="form-control" v-model="q.norm">
    </div>

    <div class="form-group">
      <label><span class="fas fa-check"></span> جواب </label>
      <select v-model="q.answer" class="form-control">
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
      </select>
    </div>

    <div class="form-group">
      <label><span class="fas fa-layer-group"></span> سطح سوال </label>
      <select v-model="q.level" class="form-control">
        <option value="easy">آسان</option>
        <option value="medium">متوسط</option>
        <option value="hard">سخت</option>
      </select>
    </div>

    <div class="form-group">
      <label for="exampleFormControlFile1"><span class="fas fa-image"></span> تصویر </label>
      <input type="file" @change="toBase64" name="img" class="form-control-file" id="exampleFormControlFile1">
      <app-errors :errors="errors.pic"></app-errors>
      <img v-if="pic" style="max-height:300px;" :src="pic" class="rounded mx-auto d-block img-fluid my-2">
    </div>

    <div class="form-group">
      <label><span class="fas fa-book fa-fw"></span> <span>دسته بندی سوال</span></label>
      <select v-model="q.category" class="form-control">
        <option value="0">بدون دسته بندی</option>
        <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
      </select>
    </div>

    <button class="btn btn-primary btn-block" @click.prevent="makeQuestion">ویرایش سوال</button>

  </div>
</template>

<script>
    import Swal from 'sweetalert2';

    export default {
        mounted() {
            setTimeout(() => {
                let iframe = document.getElementById("editor_ifr");
                let tinymce = iframe.contentWindow.document.getElementById("tinymce");
                tinymce.innerHTML = this.question.desc;

                this.q.category = this.question.categories[0].id;
                setInterval(() => {
                    this.q.desc = tinymce.innerHTML;
                }, 500);
            }, 1000);

            this.question.pic = null;
        },
        name: "AppQuestionEditForm",
        props: {
            categories: {default: () => []},
            route: {default: ''},
            question: {default: () => {}}
        },
        data() {
            return {
                pic: this.question.pic,
                q: Object.assign(this.question),
                errors: []
            }
        },
        methods: {
            toBase64(val) {
                let files = val.target.files;
                if (files && files[0]) {

                    let FR = new FileReader();

                    FR.addEventListener("load", (e) => {
                        this.question.pic = e.target.result;
                    });

                    FR.readAsDataURL(files[0]);
                }
            }
            ,
            makeQuestion() {
                this.load();
                axios.patch(this.route, this.q)
                    .then(({data}) => {
                        Swal.fire({
                            text: 'با موفقیت انجام شد.',
                            icon: 'success',
                            confirmButtonText: 'بسیار خوب',
                            timer: 5000,
                        });
                    })
                    .catch(({response}) => {
                        Swal.fire({
                            text: 'مشکلی در ویرایش سوال رخ داده است.',
                            icon: 'error',
                            confirmButtonText: 'بسیار خوب',
                            timer: 5000,
                        });
                        this.errors = response.data.errors;
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
