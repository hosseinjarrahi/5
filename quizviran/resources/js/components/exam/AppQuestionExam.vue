<template>
  <app-content-border-box :title="` سوالات  ${exam.name}`" icon="question">
    <div class="bg-dark-gray p-2 p-md-3 my-2 rounded">


      <div class="d-flex flex-column w-100 p-2 justify-content-center align-items-center" v-if="!questions.length">
        <span class="my-2 fas fa-diagnoses fa-4x"></span>
        <span class="my-2">آزمون شما فاقد سوال است.</span>
      </div>

      <template v-for="(question,index) in questions">
        <div class="w-100  border-light border rounded p-2 overflow-hidden my-1">

          <app-check-box @change="handleSelecting" :qid="question.id">
            <div v-html="question.desc"></div>
          </app-check-box>

          <div class="d-flex rounded flex-row justify-content-around justify-content-md-end mt-3 align-items-center py-1">

            <a class="mx-1 btn btn-sm bg-dark-gray"
               :href="`/quiz/question/${question.id}/edit`">
              <span class="fas fa-edit"></span>
              <span>ویرایش</span>
            </a>

            <a class="btn btn-sm bg-dark-gray"
               :href="`/quiz/question/${question.id}/delete-from-exam?exam=${exam.id}`">
              <span class="fas fa-trash"></span>
              <span>حذف از آزمون</span>
            </a>

            <a class="mx-1 btn btn-sm bg-dark-gray"
               :href="`/quiz/question/${question.id}`">
              <span class="fas fa-eye"></span>
              <span>مشاهده</span>
            </a>

          </div>

        </div>
      </template>

    </div>

    <div class="d-flex flex-row" v-if="selected.length > 0">
      <div class="btn rounded btn-danger btn-block" @click="deleteFromExam">حذف از آزمون</div>
    </div>
  </app-content-border-box>
</template>

<script>
  import {mapActions, mapGetters} from 'vuex';

  export default {
    name: "AppQuestionExam",
    props: {
      'exam': {default: ''},
    },
    data() {
      return {
        selected: []
      }
    },
    methods: {
      ...mapActions(['removeQuestionFromExam']),

      deleteFromExam() {
        this.removeQuestionFromExam(this.selected);
        this.selected = [];
      },

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
    },

    computed: {
      ...mapGetters({
        questions: 'examQuestions'
      })
    }
  }
</script>

<style scoped>

</style>
