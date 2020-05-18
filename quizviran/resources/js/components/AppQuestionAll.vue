<template>
  <app-content-border-box title="تمامی سوالات شما" icon="question-circle">
    <div class="bg-dark-gray p-2 p-md-3 my-2 rounded">

      <template v-for="(question,index) in questions">
        <div>

          <app-check-box @change="handleSelecting" :qid="question.id">
            <vue-mathjax :formula="`${index+1} - ${question.desc} `"></vue-mathjax>
          </app-check-box>

          <div class="d-flex flex-row justify-content-center mt-3 bg-gray rounded align-items-center py-1">

            <a class="mx-1 badge badge-info"
               :href="`/quiz/question/${question.id}/edit`"> ویرایش
            </a>

            <a class="mx-1 badge badge-light"
               :href="`/quiz/question/${question.id}`">مشاهده سوال
            </a>

          </div>

          <a class="btn py-0 bg-light btn-block"
             :href="`/quiz/question/${question.id}/add-to-exam?exam=${id}`">افزودن به آزمون
          </a>

        </div>
        <div class="dropdown-divider"></div>
      </template>

    </div>

    <div class="d-flex flex-row" v-if="selected.length > 0">
      <div class="rounded btn btn-info btn-block" @click="AddToExam">افزودن به آزمون</div>
    </div>

  </app-content-border-box>
</template>

<script>
    import AppCheckBox from "./AppCheckBox";
    import Swal from 'sweetalert2';

    export default {
        components: {AppCheckBox},
        props: ['id', 'questions'],
        name: "AppQuestionAll",
        data() {
            return {
                selected: []
            }
        },
        methods: {
            handleSelecting() {
                let flag = true;
                this.selected.forEach((val, index) => {
                    if (val == arguments[0].selected) {
                        this.selected.splice(index, 1);
                        flag = false;
                    }
                });

                flag && this.selected.push(arguments[0].selected);
            },
            AddToExam() {
                this.load();
                axios.post('/quiz/question/add-many-to-exam?exam=' + this.id, {
                    questions: this.selected
                })
                    .then(res => {
                        Swal.fire({
                            text: 'با موفقیت اضافه شد.',
                            icon: 'success',
                            confirmButtonText: 'بسیار خوب',
                            timer: 3000
                        });
                        window.location.reload();
                    })
                    .catch(err => {
                        Swal.fire({
                            text: 'مشکلی در ثبت رخ داده است',
                            icon: 'error',
                            confirmButtonText: 'بسیار خوب',
                            timer: 3000
                        });
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
