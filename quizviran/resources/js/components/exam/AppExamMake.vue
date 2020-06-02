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
    import Swal from 'sweetalert2';

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
            make() {
                this.load();
                axios.post('/quiz/exam', {room: this.room, ...this.quiz})
                    .then(res => {
                        if (res.data == 'ok')
                            return location.reload();
                    })
                    .catch(err => {
                        Swal.fire({
                            text: 'مشکلی رخ داده',
                            icon: 'error',
                            timer: 3000
                        });
                    })
                    .then(() => {
                        this.closeLoad();
                    });

            }
        }
    }
</script>

<style scoped>

</style>
