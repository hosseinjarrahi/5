<template>
  <div class="w-100">
    <div class="form-group">
      <span class="fas fa-user"></span>
      <span>نام و نام خانوادگی :</span>
      <input class="form-control" v-model="form.name">
    </div>
    <div class="form-group">
      <span class="fas fa-calendar"></span>
      <span>تاریخ تولد :</span>
      <date-picker v-model="form.birth"/>
    </div>
    <div class="form-group">
      <span class="fas fa-question"></span>
      <span>نوع کاربر :</span>
      <input disabled class="form-control" :value="form.type == 'teacher' ? 'معلم' : 'دانش آموز'" >
    </div>
    <div class="form-group">
      <span class="fas fa-pen"></span>
      <span>درباره من :</span>
      <textarea rows="6" class="form-control" v-model="form.bio"></textarea>
    </div>
    <div class="form-group">
      <span class="fas fa-eye"></span>
      <span>تغییر رمز :</span>
      <input v-model="form.password" class="form-control">
    </div>
    <button class="btn btn-primary" @click.prevent="editProfile">ویرایش اطلاعات</button>
  </div>
</template>

<script>
    export default {
        name: "AppProfileForm",
        props:['user'],
        data(){
            return {
                form:this.user
            }
        },
        methods:{
            editProfile(){
              axios.post('/profile-change',this.form)
              .then(res => {

              })
              .catch(err => {

              });
            }
        }
    }
</script>

<style scoped>

</style>