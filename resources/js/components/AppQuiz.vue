<template>
  <div class="col-11 col-md-6 p-3 my-4">
    <div class="container-fluid bg p-3 shadow rounded posisoin-relative">
      <div class="w-100 parent d-flex justify-content-center">
        <div class="title p-2 px-4 shadow rounded">
          <h4>مسابقات</h4>
        </div>
      </div>
      <div class="my-4">
        <app-quiz-card
          v-for="(quiz,index) in quizz"
          :title="quiz.name"
          :desc="quiz.desc"
          :to="quiz.link"
          :start="quiz.start"
          :id="quiz.id"
          :key="index"
        ></app-quiz-card>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    quizzes: { default: "" }
  },
  computed: {
    quizz() {
      return JSON.parse(this.quizzes);
    }
  }
};
</script>

<style scoped lang="scss">
@import "./../../sass/app.scss";

.bg {
  background: $gray; /* fallback for old browsers */
}
.parent {
  top: -10px;
  left: 0;
  position: absolute;
}
.title {
  color: white;
  background: $darkGray; /* fallback for old browsers */
  margin: auto;
}
</style>
