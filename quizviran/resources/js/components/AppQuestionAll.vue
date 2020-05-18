<template>
  <app-content-border-box title="تمامی سوالات شما" icon="question-circle">
    <div class="bg-dark-gray p-2 p-md-3 my-2 rounded">

      <template v-for="(question,index) in questions">
        <div>

          <vue-mathjax :formula="`${index+1} - ${question.desc} `"></vue-mathjax>
          <div class="d-flex flex-row justify-content-center mt-3 bg-gray rounded align-items-center py-1">

            <a class="mx-1 badge badge-info"
               :href="`/quiz/question/${question.id}/edit`"> ویرایش
            </a>

            <a class="mx-1 badge badge-light"
               :href="`/quiz/question/${question.id}`" >مشاهده سوال
            </a>

          </div>

          <a class="btn py-0 bg-light btn-block"
             :href="`/quiz/question/${question.id}/add-to-exam?exam=${id}`">افزودن به آزمون
          </a>

        </div>
        <div class="dropdown-divider"></div>
      </template>

    </div>
  </app-content-border-box>
</template>

<script>
    export default {
        props: ['id', 'questions'],
        name: "AppQuestionAll"
    }
</script>

<style scoped>

</style>
