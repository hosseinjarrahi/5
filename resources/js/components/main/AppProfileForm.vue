import Swal from "sweetalert2";
import Swal from "sweetalert2";
<template>
  <div class="w-100">

    <div class="alert alert-danger" v-for="error in errors">{{ error }}</div>

    <div class="form-group">
      <span class="fas fa-user"></span>
      <span>نام و نام خانوادگی :</span>
      <input class="form-control" v-model="form.name">
    </div>
    <div class="form-group">
      <span class="fas fa-calendar"></span>
      <span>تاریخ تولد :</span>
      <date-picker v-model="form.profile.birth" :disabled="showDate"/>
    </div>
    <div class="form-group">
      <span class="fas fa-question"></span>
      <span>نوع کاربر :</span>
      <input disabled class="form-control" :value="form.type == 'teacher' ? 'معلم' : 'دانش آموز'">
    </div>
    <div class="form-group">
      <span class="fas fa-pen"></span>
      <span>درباره من :</span>
      <textarea rows="6" class="form-control" v-model="form.profile.bio"></textarea>
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
    import Swal from 'sweetalert2';

    export default {
        name: "AppProfileForm",
        props: ['user'],
        created() {
          this.showDate = this.form.profile.birth ? true : false;
        },
        data() {
            return {
                form: this.user,
                errors: [],
                showDate:null
            }
        },
        methods: {
            editProfile() {
                this.load();
                axios.post('/profile-change', this.form)
                    .then(res => {
                        Swal.fire({
                            text: res.data.message,
                            icon: 'success',
                            confirmButtonText: 'بسیار خوب',
                            timer: 5000
                        });
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors;
                    })
                .then(()=>{
                    this.closeLoad();
                });
            }
        }
    }
</script>

<style scoped>

</style>