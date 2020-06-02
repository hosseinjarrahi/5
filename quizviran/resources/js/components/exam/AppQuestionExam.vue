<template>
  <app-content-border-box :title="` سوالات  ${name}`" icon="question">
    <div class="bg-dark-gray p-2 p-md-3 my-2 rounded">

      <template v-for="(question,index) in questions">
        <div>

          <app-check-box @change="handleSelecting" :qid="question.id">
            <vue-mathjax :formula="`${index+1} - ${question.desc}`"></vue-mathjax>
          </app-check-box>

          <div class="d-flex flex-row justify-content-center mt-3 bg-gray align-items-center py-1">

            <a class="badge mx-1 badge-info btn btn-primary"
               :href="`/quiz/question/${question.id}/edit`">ویرایش
            </a>

            <a class="mx-1 badge badge-light"
               :href="`/quiz/question/${question.id}`">مشاهده سوال
            </a>

            <a class="badge badge-danger"
               :href="`/quiz/question/${question.id}/delete-from-exam?exam=${id}`">حذف از آزمون
            </a>

          </div>

        </div>
        <div class="dropdown-divider"></div>
      </template>

    </div>

    <div class="d-flex flex-row" v-if="selected.length > 0">
      <div class="btn rounded btn-danger btn-block" @click="deleteFromExam">حذف از آزمون</div>
    </div>
  </app-content-border-box>
</template>

<script>
    import Swal from 'sweetalert2';

    export default {
        name: "AppQuestionExam",
        props: {
            'questions' : {default:''},
            'id' : {default:''},
            'name' : {default:''}
        },
        data() {
            return {
                selected: []
            }
        },
        methods: {
            handleSelecting() {
                let flag = true;
                this.selected.forEach((val,index) => {
                    if (val == arguments[0].selected) {
                        this.selected.splice(index, 1);
                        flag = false;
                    }
                });

                flag && this.selected.push(arguments[0].selected);
            },
            deleteFromExam(){
                this.load();
                axios.post('/quiz/question/delete-many-from-exam?exam=' + this.id,{
                    questions:this.selected
                })
                .then(res => {
                    Swal.fire({
                        text: 'با موفقیت حذف شد.',
                        icon: 'success',
                        confirmButtonText: 'بسیار خوب',
                        timer: 3000
                    });
                    this.questions = this.questions.filter(val => this.selected.indexOf(val.id) === -1);
                    this.selected = [];
                })
                .catch(err => {
                    Swal.fire({
                        text: 'مشکلی در ثبت رخ داده است',
                        icon: 'error',
                        confirmButtonText: 'بسیار خوب',
                        timer: 3000
                    });
                })
                .finally(()=>{
                    this.closeLoad();
                });
            }
        }
    }
</script>

<style scoped>

</style>
