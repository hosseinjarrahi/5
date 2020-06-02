<template>
  <div class="p-2 w-100">
    <div class="form-group">
      <select name="type" class="form-control">
        <option value="test">تستی</option>
        <option value="descriptive">تشریحی</option>
      </select>
    </div>
    <div class="form-group">
      <label><span class="fas fa-paragraph"></span>توضیحات</label>

      <textarea v-model="question.formula" name="desc" class="mb-5 form-control" cols="30" rows="10"></textarea>
      <app-content-border-box class="mx-auto" style="width: 90%" title="پیش نمایش سوال" v-if="!!question.formula">
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
      <label for="exampleFormControlFile1"><span class="fas fa-image"></span> تصویر </label>
      <input type="file" name="img" class="form-control-file" id="exampleFormControlFile1">
    </div>

    <div class="form-group">
      <label><span class="fas fa-book fa-fw"></span> <span>دسته بندی سوال</span></label>
      <select model="question.category" class="form-control">
        <option value="0" selected>بدون دسته بندی</option>
        <option v-for="category in categories" :key="'select'+category.id" :value="category.id">{{ category.name }}</option>
      </select>
    </div>

    <button class="btn btn-primary btn-block">افزودن سوال</button>
  </div>
</template>

<script>
    export default {
        name: "AppQuestionAddForm",
        props: {
            categories: {default: []}
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
                    category: null
                }
            }
        }
    }
</script>

<style scoped>

</style>
