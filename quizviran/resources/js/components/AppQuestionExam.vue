<template>
  <app-content-border-box title="سوالات آزمون" icon="question">
    <div class="bg-dark-gray p-2 p-md-3 my-2 rounded">

      <template v-for="(question,index) in questions">
        <div>
          <vue-mathjax :formula="`${index+1} - ${question.desc}`"></vue-mathjax>
          <div class="d-flex flex-row justify-content-center mt-3 bg-gray rounded align-items-center py-1">

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
  </app-content-border-box>
</template>

<script>
    export default {
        name: "AppQuestionExam",
        props: ['questions', 'id']
    }
</script>

<style scoped>

</style>
