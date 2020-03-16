<template>
  <form>
    <div class="form-group">
      <label>عنوان آزمون</label>
      <input v-model="quiz.name" class="form-control">
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
        data(){
            return {
                quiz:{
                    start:'',
                    name:'',
                    duration:''
                },
            }
        },
        methods:{
            make(){
                axios.post('/quiz',this.quiz)
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
                });

            }
        }
    }
</script>

<style scoped>

</style>