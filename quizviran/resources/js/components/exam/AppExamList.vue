<template>
  <div class="w-100">
    <div class="alert alert-info">
      آزمون هایی که پسزمینه آبی دارند برای دانش آموزان قابل نمایش هستند.
    </div>

    <table class="text-center table table-responsive-sm table-responsive-lg table-responsive-md table-striped">
      <tr>
        <td>عنوان آزمون</td>
        <td><span class="fas fa-plus"></span> <span>افزودن سوال</span></td>
        <td><span class="fas fa-edit"></span> <span>ویرایش</span></td>
        <td><span class="fas fa-eye"></span> <span>مشاهده آزمون</span></td>
        <td><span class="fas fa-poll"></span> <span>نتایج</span></td>
        <td><span class="fas fa-stamp"></span> <span>تمدید (5 دقیقه)</span></td>
        <td><span class="fas fa-recycle"></span> <span>نمایش</span></td>
      </tr>

      <tr v-if="exams.length" v-for="(exam,index) in examList" :class="[exam.show ? 'bg-info' : 'bg-dark-gray']">
        <td>{{ exam.name }}</td>
        <td><a class="btn btn-sm dark-shadow btn-light" :href="exam.addQuestionLink">افزودن سوال</a></td>
        <td><a class="btn btn-sm dark-shadow btn-light" :href="exam.editLink">ویرایش</a></td>
        <td><a class="btn btn-sm dark-shadow btn-light" :href="exam.link">مشاهده</a></td>
        <td><a class="btn btn-sm dark-shadow btn-light" :href="exam.detailLink">جزییات</a></td>
        <td>
          <button class="btn btn-warning btn-sm dark-shadow" @click.prevent="revival({exam:exam,sub:''})">تمدید</button>
          <button class="btn btn-secondary btn-sm dark-shadow" @click.prevent="revival({exam:exam,sub:'sub'})">کاهش</button>
        </td>
        <td>
          <button @click="toggleShowExam({exam:exam,index:index})" class="dark-shadow btn btn-sm btn-danger"
                  v-text="exam.show ? 'مخفی کردن' : 'ظاهر کردن'">
          </button>
        </td>
      </tr>

      <tr v-else>
        <td colspan="7">آزمونی وجود ندارد ...</td>
      </tr>

    </table>
  </div>
</template>

<script>
  import {mapMutations, mapActions, mapGetters} from 'vuex';

  export default {
    name: "AppExamList",
    props: {
      exams: {default: []}
    },
    created() {
      this.setExams(this.exams);
    },
    methods: {
      ...mapMutations(['setExams']),
      ...mapActions(['revival','toggleShowExam']),

    },
    computed: {
      ...mapGetters({
        examList: 'exams'
      })
    }
  }
</script>

<style scoped>

</style>
