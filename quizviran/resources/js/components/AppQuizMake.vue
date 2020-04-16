<template>
  <form>
    <div class="form-group">
      <label>عنوان آزمون</label>
      <input v-model="quiz.name" class="form-control">
    </div>
    <div class="form-group">
      <label>توضیحات آزمون</label>
      <input v-model="quiz.desc" class="form-control">
    </div>
    <div class="form-group">
      <label>زمان شروع مسابقه</label>
      <date-picker locale="fa" format="YYYY/MM/DD HH:mm:ss" v-model="quiz.start" type="datetime" />
    </div>
    <div class="form-group">
      <label>مدت زمان مسابقه به دقیقه</label>
      <input class="form-control" v-model="quiz.duration">
    </div>
    <button class="btn btn-primary btn-block" @click.prevent="make">ساخت آزمون</button>
  </form>
</template>

<script>
  import Swal from 'sweetalert2';
    export default {
        name: "AppQuizMake",
        props:['room'],
        data(){
            return {
                quiz:{
                    start:'',
                    name:'',
                    duration:'',
                    desc:''
                },
            }
        },
        methods:{
            make(){
                this.load();
                axios.post('/quiz/exam',{room:this.room,...this.quiz})
                .then(res => {
                  if(res.data == 'ok')
                      return location.reload();
                })
                .catch(err => {
                    Swal.fire({
                        text:'مشکلی رخ داده',
                        icon:'error',
                        timer:3000
                    });
                })
                .then(()=>{
                    this.closeLoad();
                });

            }
        }
    }
</script>

<style scoped>

</style>