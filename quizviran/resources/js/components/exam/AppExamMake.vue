<template>
  <transition-group name="slide" mode="out-in" class="w-100">
    <app-main-box key="one" v-show="!edit" :dark="true" title="ایجاد آزمون" icon="file-alt">
      <div class="form-group">
        <label><span class="fas fa-heading"></span> <span>عنوان آزمون</span></label>
        <input v-model="quiz.name" class="form-control">
      </div>
      <div class="form-group">
        <label><span class="fas fa-align-justify"></span> <span>توضیحات آزمون</span></label>
        <input v-model="quiz.desc" class="form-control">
      </div>
      <div class="form-group">
        <label><span class="fas fa-clock"></span> <span>زمان شروع آزمون</span></label>
        <date-picker class="text-dark" locale="fa" format="jYYYY-jMM-jDD HH:mm:ss" v-model="quiz.start" type="datetime"/>
      </div>
      <div class="form-group">
        <label><span class="fas fa-clock"></span> <span>مدت زمان آزمون به دقیقه</span></label>
        <input class="form-control" v-model="quiz.duration">
      </div>
      <button class="btn py-0 btn-primary btn-block" @click.prevent="createExam({room,quiz})">ساخت آزمون</button>
    </app-main-box>

    <app-main-box id="editExam" key="tow" v-show="edit" :dark="true" title="ویرایش آزمون" icon="edit">
      <div @click="resetEditExam" class="pointer d-flex flex-row align-items-center justify-content-end">
        <span>بازگشت به ایجاد آزمون</span>
        <span class="fas fa-arrow-left mx-1"></span>
      </div>
      <div class="form-group">
        <label><span class="fas fa-heading"></span> <span>عنوان آزمون</span></label>
        <input v-model="edit.name" class="form-control">
      </div>
      <div class="form-group">
        <label><span class="fas fa-align-justify"></span> <span>توضیحات آزمون</span></label>
        <input v-model="edit.desc" class="form-control">
      </div>
      <div class="form-group">
        <label><span class="fas fa-clock"></span> <span>زمان شروع آزمون</span></label>
        <date-picker class="text-dark" locale="fa" format="jYYYY-jMM-jDD HH:mm:ss" v-model="edit.start" type="datetime"/>
      </div>
      <div class="form-group">
        <label><span class="fas fa-clock"></span> <span>مدت زمان آزمون به دقیقه</span></label>
        <input class="form-control" v-model="edit.duration">
      </div>
      <button class="btn btn-primary btn-block" @click.prevent="updateExam(edit)">ویرایش آزمون</button>
    </app-main-box>
  </transition-group>
</template>

<script>
  import {mapActions, mapGetters, mapMutations} from 'vuex';

  export default {
    name: "AppExamMake",

    props: ['room'],

    data() {
      return {
        quiz: {
          start: '',
          name: '',
          duration: '',
          desc: ''
        }
      }
    },

    methods: {
      ...mapActions(['createExam','updateExam']),
      ...mapMutations(['resetEditExam'])
    },

    computed: {
      ...mapGetters({
        edit: 'editingExam'
      })
    }
  }
</script>
