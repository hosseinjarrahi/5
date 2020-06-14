<template>
  <div class="w-100">

    <div class="form-group">
      <span class="fas fa-user"></span>
      <span>نام و نام خانوادگی :</span>
      <input class="form-control" v-model="form.name">
      <span v-if="errors.name" class="text-danger figure-caption">{{ errors.name[0] }}</span>
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
      <span v-if="errors.bio" class="text-danger figure-caption">{{ errors.bio[0] }}</span>
    </div>
    <div class="form-group">
      <span class="fas fa-eye"></span>
      <span>تغییر رمز :</span>
      <input type="password" min="8" v-model="form.password" class="form-control">
      <span v-if="errors.password" class="text-danger figure-caption">{{ errors.password[0] }}</span>
    </div>
    <button class="btn btn-primary" @click.prevent="editProfile">ویرایش اطلاعات</button>
  </div>
</template>

<script>
    import {mapActions, mapMutations} from "vuex";

    export default {
        name: "AppProfileForm",
        props: ['user'],
        created() {
          this.showDate = this.form.profile.birth ? true : false;
        },
        data() {
            return {
                form: this.user,
                errors: {
                    password: null,
                    name: null,
                    bio: null,
                },
                showDate:null
            }
        },
        methods: {
          ...mapMutations(['loadOff', 'loadOn']),
          ...mapActions(['errorAlert', 'successAlert']),
          editProfile() {
                this.errors.password = null;
                this.errors.bio = null;
                this.errors.name = null;

                this.loadOn();
                axios.post('/profile-change', this.form)
                    .then(res => {
                        this.successAlert(res.data.message);
                    })
                    .catch(({ response }) => {
                        this.errors.password = response.data.errors.password;
                        this.errors.bio = response.data.errors.bio;
                        this.errors.name = response.data.errors.name;
                    })
                .then(()=>{
                    this.loadOff();
                });
            }
        }
    }
</script>
