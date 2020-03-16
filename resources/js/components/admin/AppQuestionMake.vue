<template>
  <form method="post" enctype="multipart/form-data" action="{{ route('question.add') }}">
    <div class="form-group">
      <select name="type" class="form-control">
        <option value="test">تستی</option>
        <option value="descriptive">تشریحی</option>
      </select>
    </div>
    <div class="form-group">
      <lable>توضیحات</lable>
      <textarea class="form-control" name="desc" cols="30" rows="10"></textarea>
    </div>
    <div class="form-group">
      <label>گزینه A</label>
      <input class="form-control" name="A">
    </div>
    <div class="form-group">
      <label>گزینه B</label>
      <input class="form-control" name="A">
    </div>
    <div class="form-group">
      <label>گزینه C</label>
      <input class="form-control" name="A">
    </div>
    <div class="form-group">
      <label>گزینه D</label>
      <input class="form-control" name="A">
    </div>
    <div class="form-group">
      <label>جواب</label>
      <select name="type" class="form-control">
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
      </select>
    </div>
    <input type="hidden" name="quizId" value="{{ $quiz->id }}">
    <button class="btn btn-primary btn-block" @click.prevent="make">افزودن سوال</button>
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