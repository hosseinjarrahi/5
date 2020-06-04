<template>
  <div class="p-2 w-100">
    <div class="form-group">
      <select name="type" v-model="question.type" class="form-control">
        <option value="test">تستی</option>
        <!--        <option value="descriptive">تشریحی</option>-->
      </select>
    </div>
    <div class="form-group">
      <label><span class="fas fa-paragraph"></span>توضیحات</label>

      <textarea v-model="question.formula" name="desc" :class="['form-control', { 'is-invalid' : errors.formula && !question.formula.length } ]" cols="30"
                rows="10"></textarea>
      <app-errors :errors="errors.formula">وارد کردن توضیحات الزامی است</app-errors>

      <app-content-border-box class="mt-5 mx-auto" title="پیش نمایش سوال" v-if="!!question.formula">
        <vue-mathjax style="white-space: pre-wrap" :formula="question.formula"></vue-mathjax>
      </app-content-border-box>

    </div>
    <div class="form-group">
      <label><span class="fas fa-check-square"></span> گزینه A </label>
      <input class="form-control" v-model="question.A">
    </div>
    <div class="form-group">
      <label><span class="fas fa-check-square"></span> گزینه B </label>
      <input class="form-control" v-model="question.B">
    </div>
    <div class="form-group">
      <label><span class="fas fa-check-square"></span> گزینه C </label>
      <input class="form-control" v-model="question.C">
    </div>
    <div class="form-group">
      <label><span class="fas fa-check-square"></span> گزینه D </label>
      <input class="form-control" v-model="question.D">
    </div>
    <div class="form-group">
      <label><span class="fas fa-star"></span> امتیاز سوال </label>
      <input required type="number" class="form-control" v-model="question.norm">
    </div>
    <div class="form-group">
      <label><span class="fas fa-check"></span> جواب </label>
      <select v-model="question.answer" class="form-control">
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
      </select>
    </div>

    <div class="form-group">
      <label><span class="fas fa-layer-group"></span> سطح سوال </label>
      <select v-model="question.level" class="form-control">
        <option value="easy">آسان</option>
        <option value="medium">متوسط</option>
        <option value="hard">سخت</option>
      </select>
    </div>

    <div class="form-group">
      <label for="exampleFormControlFile1"><span class="fas fa-image"></span> تصویر </label>
      <input type="file" @change="toBase64" name="img" class="form-control-file" id="exampleFormControlFile1">
      <app-errors :errors="errors.pic"></app-errors>
    </div>

    <div class="form-group">
      <label><span class="fas fa-book fa-fw"></span> <span>دسته بندی سوال</span></label>
      <select v-model="question.category" class="form-control">
        <option value="0">بدون دسته بندی</option>
        <option v-for="category in categories" :key="'select' + category.id" :value="category.id">{{ category.name }}</option>
      </select>
    </div>

    <button class="btn btn-primary btn-block" @click.prevent="makeQuestion">افزودن سوال</button>
  </div>
</template>

<script>
    import Swal from 'sweetalert2';

    export default {
        name: "AppQuestionAddForm",
        props: {
            categories: {default: () => []},
            route: {default: ''},
        },
        data() {
            return {
                question: {
                    A: '',
                    B: '',
                    C: '',
                    D: '',
                    norm: 0,
                    answer: 'A',
                    formula: '',
                    type: 'test',
                    category: 0,
                    pic: '',
                    level: 'easy',
                },
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
            },
            makeQuestion() {
                this.load();
                axios.post(this.route, this.question)
                    .then(({data}) => {
                        Swal.fire({
                            text: 'با موفقیت انجام شد.',
                            icon: 'success',
                            confirmButtonText: 'بسیار خوب',
                            timer: 5000,
                        });
                        window.EventBus.$emit('addQuestion', data.question);
                        window.location.reload();
                    })
                    .catch(({response}) => {
                        Swal.fire({
                            text: 'مشکلی در افزودن سوال رخ داده است.',
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
