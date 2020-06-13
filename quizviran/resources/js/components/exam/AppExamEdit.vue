<template>
  <app-main-box :dark="true" title="ویرایش آزمون" icon="edit">
    <form>
      <div class="form-group">
        <label><span class="fas fa-heading"></span> <span>عنوان آزمون</span></label>
        <input v-model="edit.name" class="form-control">
      </div>
      <div class="form-group">
        <label><span class="fas fa-align-justify"></span> <span>توضیحات آزمون</span></label>
        <input v-model="edit.desc" class="form-control">
      </div>
      <div class="form-group">
        <label><span class="fas fa-clock"></span> <span>زمان شروع آزمون</span></label>
        <date-picker class="text-dark" locale="fa" format="jYYYY-jMM-jDD HH:mm:ss" v-model="edit.start" type="datetime"/>
      </div>
      <div class="form-group">
        <label><span class="fas fa-clock"></span> <span>مدت زمان آزمون به دقیقه</span></label>
        <input class="form-control" v-model="edit.duration">
      </div>
      <button class="btn btn-primary btn-block" @click.prevent="update">ویرایش آزمون</button>
    </form>
  </app-main-box>
</template>

<script>
  import {mapActions, mapMutations} from 'vuex';

  export default {
    name: "AppExamEdit",
    props: ['exam'],
    mounted() {
      this.edit.start = this.exam.startForEdit;
    },
    data() {
      return {
        edit: Object.assign(this.exam),
      }
    },
    methods: {
      ...mapActions(['successAlert', 'errorAlert']),
      ...mapMutations(['loadOn', 'loadOff']),
      update() {
        this.loadOn();
        axios.put('/quiz/exam/' + this.edit.id, this.edit)
          .then(res => {
            this.successAlert(res.data.message);
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
