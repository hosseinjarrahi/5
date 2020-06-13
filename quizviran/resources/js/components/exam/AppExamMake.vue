<template>
  <app-main-box :dark="true" title="ایجاد آزمون" icon="file-alt">

    <form>
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
      <button class="btn py-0 btn-primary btn-block" @click.prevent="make">ساخت آزمون</button>
    </form>
  </app-main-box>
</template>

<script>
  import {mapActions, mapMutations} from 'vuex';

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
        },
      }
    },
    methods: {
      ...mapActions(['successAlert', 'errorAlert', 'reload']),
      ...mapMutations(['loadOn', 'loadOff']),
      make() {
        this.loadOn();
        axios.post('/quiz/exam', {room: this.room, ...this.quiz})
          .then(res => {
            if (res.data == 'ok')
              return this.reload();
          })
          .catch(err => {
            this.errorAlert();
          })
          .then(() => {
            this.loadOff();
          });
      }
    }
  }
</script>
