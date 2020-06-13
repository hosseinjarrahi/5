<template>
  <app-content-border-box title="تمامی سوالات شما" icon="question-circle">
    <div class="bg-dark-gray p-2 p-md-3 my-2 rounded">

      <app-accordion-item
        class="my-1"
        v-for="category in categories"
        :key="'accordion' + category.id"
        :title="category.name"
      >
        <template v-for="(question,index) in category.questions">
          <div class="w-100  border-light border rounded p-2 overflow-hidden my-1">

            <app-check-box @change="handleSelecting" :qid="question.id">
              <div v-html="question.desc"></div>
            </app-check-box>

            <div class="d-flex rounded flex-row justify-content-end mt-3 align-items-center py-1">

              <a class="mx-1 btn btn-sm bg-dark-gray"
                 :href="`/quiz/question/${question.id}/edit`">
                <span class="fas fa-edit"></span>
                <span>ویرایش</span>
              </a>

              <a class="mx-1 btn btn-sm bg-dark-gray"
                 :href="`/quiz/question/${question.id}`">
                <span class="fas fa-eye"></span>
                <span>مشاهده</span>
              </a>

            </div>

          </div>
        </template>

      </app-accordion-item>

      <app-accordion-item title="بدون دسته بندی">

        <template v-for="(question,index) in questions">
          <div class="w-100 border-light border rounded p-2 overflow-hidden my-1">

            <app-check-box @change="handleSelecting" :qid="question.id">
              <div v-html="question.desc"></div>
            </app-check-box>

            <div class="d-flex rounded flex-row justify-content-end mt-3 align-items-center py-1">

              <a class="mx-1 btn btn-sm bg-dark-gray"
                 :href="`/quiz/question/${question.id}/edit`">
                <span class="fas fa-edit"></span>
                <span>ویرایش</span>
              </a>

              <a class="mx-1 btn btn-sm bg-dark-gray"
                 :href="`/quiz/question/${question.id}`">
                <span class="fas fa-eye"></span>
                <span>مشاهده</span>
              </a>

            </div>

          </div>
        </template>

      </app-accordion-item>

    </div>

    <div class="d-flex flex-row" v-if="selected.length > 0">
      <div class="rounded btn btn-info btn-block" @click="AddToExam">افزودن به آزمون</div>
    </div>

  </app-content-border-box>
</template>

<script>

  import {mapActions, mapMutations} from "vuex";

  export default {
    props: ['id', 'questions', 'categories'],
    name: "AppQuestionAll",
    data() {
      return {
        selected: []
      }
    },
    methods: {
      ...mapActions(['successAlert', 'errorAlert', 'reload']),
      ...mapMutations(['loadOn', 'loadOff']),

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
        this.loadOn();
        axios.post('/quiz/question/add-many-to-exam?exam=' + this.id, {
          questions: this.selected
        })
          .then(res => {
            this.successAlert();
            this.reload();
          })
          .catch(err => {
            this.errorAlert();
          })
          .finally(() => {
            this.loadOff();
          });
      }
    }
  }
</script>

<style scoped>

</style>
