<template>
  <table class="table shadow table-striped table-hover">
    <tr>
      <td>رتبه</td>
      <td>نام کاربر</td>
      <td>امتیاز</td>
      <td>جزییات</td>
    </tr>
    <tr v-for="(user,index) in users" :key="index">
      <td>{{ index+1 }}</td>
      <td>{{ user.name }}</td>
      <td>{{ user.pivot.norm }}</td>
      <td>
        <div class="pointer btn btn-primary" @click="show(user.pivot.answers)">جزییات</div>
      </td>
    </tr>
    <app-modal :fluid="true" title="جزییات" v-if="open" @close="open = false">
      <div v-for="(question,index) in questions"
           :key="index"
           :class="['shadow my-2 rounded'
           ,question.answer == userAnswer(question.id) ? 'border-success':'border-danger']"
           style="border-width: 3px;border-style:solid"
      >

        <div class="p-2">
          {{ index+1 }}
          <span class="fas fa-arrow-left"></span>
          <span> سوال: </span>
          <div v-html="question.desc"></div>
        </div>

        <div class="col-12">

          <div class="row p-2  justify-content-center my-2">
            <div class="col-12">
              <span class="fas fa-user"></span>
              <span> پاسخ ها: </span>
            </div>
            <div class="shadow my-2 rounded col-12 col-md-2 mx-2">1 :
              <div v-html="question.A"></div>
            </div>
            <div class="shadow my-2 rounded col-12 col-md-2 mx-2">2 :
              <div v-html="question.B"></div>
            </div>
            <div class="shadow my-2 rounded col-12 col-md-2 mx-2">3 :
              <div v-html="question.C"></div>
            </div>
            <div class="shadow my-2 rounded col-12 col-md-2 mx-2">4 :
              <div v-html="question.D"></div>
            </div>
          </div>

        </div>

        <div class="d-flex flex-row">
          <div class="p-2 my-2">
            <span class="fas fa-user"></span>
            <span> پاسخ کاربر: </span>
            <span>{{userAnswer(question.id)}}</span>
          </div>

          <div class="p-2 my-2">
            <span class="fas fa-check"></span>
            <span> پاسخ درست: </span>
            <span>{{question.answer}}</span>
          </div>
        </div>

      </div>
    </app-modal>
  </table>
</template>

<script>
    export default {
        name: "AppResultList",
        props: ['users', 'questions'],
        data() {
            return {
                answers: null,
                open: false
            }
        },
        methods: {
            show(answers) {
                this.answers = JSON.parse(answers);
                this.open = true;
            },
            userAnswer(id) {
                return (this.answers.find(val => val.id == id)).selected;
            }
        }
    }
</script>

<style scoped>

</style>
