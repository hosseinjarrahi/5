<template>
  <div class="modaler">
    <div class="modal-dialog" style="overflow: hidden" role="document">
      <div class="modal-content">
        <div class="modal-header">

          <transition name="fade">
            <h5 class="modal-title" key="a" v-if="login">فرم ورود</h5>
            <h5 class="modal-title" key="b" v-else-if="register">فرم ثبت نام</h5>
            <h5 class="modal-title" key="c" v-else-if="recovery">فرم بازیابی</h5>
            <h5 class="modal-title" key="d" v-else-if="recoveryCode">کد تایید</h5>
          </transition>

          <button type="button" class="close" @click="close">
            <span aria-hidden="true">&times;</span>
          </button>

        </div>

        <div class="modal-body">

          <transition name="fade" mode="out-in">
            <div v-if="login" key="login">
              <form>
                <div class="form-group">
                  <lable>ایمیل:</lable>
                  <input v-model="login.username" type="text" name="username" class="form-control"/>
                </div>
                <div class="form-group">
                  <lable>رمز عبور:</lable>
                  <input v-model="login.password" type="password" name="password" class="form-control"/>
                </div>
                <a href class="forget password p-2 mb-2" @click.prevent="changeState('recovery')">فراموشی رمز عبور</a>
                <button class="btn btn-primary btn-block my-2">ورود</button>
              </form>

              <div class="modal-footer">
                <a href type="button" class="btn btn-primary" @click.prevent="changeState('register')">ثبت نام</a>
              </div>
            </div>


            <div v-else-if="register" key="register">
              <form>
                <div class="form-group">
                  <label>شماره تلفن</label>
                  <input v-model="register.phone" name="phone" class="form-control" type="text" required min="10">
                </div>
                <div class="form-group">
                  <label>نام و نام خانوادگی</label>
                  <input v-model="register.name" name="name" class="form-control" type="text" required>
                </div>
                <div class="form-group">
                  <label>نام کاربری</label>
                  <input v-model="register.handle" name="handle" class="form-control" type="text" required min="4" max="36">
                </div>
                <div class="form-group">
                  <label>رمز عبور</label>
                  <input v-model="register.password" name="password" class="form-control" type="password" required min="8" max="36">
                </div>
                <div class="form-group">
                  <label>تکرار رمز عبور</label>
                  <input v-model="register.confirm" name="confirm" class="form-control" type="password" required min="8" max="36">
                </div>
                <button class="btn btn-primary">ارسال کد تایید</button>
              </form>
            </div>

            <div v-else-if="registerCode" key="registerCode">
              <form>
                <p class="text-center">
                  <span>کد ارسال شده به شماره </span>
                  <b>{{ phone }}</b>
                  <span> را وارد کنید </span>
                </p>
                <div class="form-group">
                  <label>کد تایید</label>
                  <input name="verify" class="form-control" type="text" required>
                </div>
                <button class="btn btn-primary">ثبت نام</button>
              </form>
            </div>

            <div v-else-if="recovery" key="recovery">
              <form>
                <div class="form-group">
                  <lable>تلفن:</lable>
                  <input type="text" name="username" class="form-control"/>
                </div>
                <button class="btn btn-primary btn-block my-2">ارسال کد</button>
              </form>
            </div>

          </transition>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
        data() {
            return {
                phone:'',
                login: true,
                register: false,
                recovery: false,
                registerCode: false,
                recoveryCode: false,
                register:{
                    phone:'',
                    name:'',
                    handle:'',
                    password:'',
                    confirm:'',
                },
                login:{
                    username:'',
                    password:''
                }
            }
        },
        methods: {
            close() {
                this.$emit('close');
            },
            login() {

            },
            changeState(s) {
                switch (s) {
                    case 'login':
                        this.login = true;
                        this.register = false;
                        this.recovery = false;
                        this.registerCode = false;
                        this.recoveryCode = false;
                        break;
                    case 'register':
                        this.login = false;
                        this.register = true;
                        this.recovery = false;
                        this.registerCode = false;
                        this.recoveryCode = false;
                        break;
                    case 'recovery':
                        this.login = false;
                        this.register = false;
                        this.recovery = true;
                        this.registerCode = false;
                        this.recoveryCode = false;
                        break;
                    case 'registerCode':
                        this.login = false;
                        this.register = false;
                        this.recovery = false;
                        this.registerCode = true;
                        this.recoveryCode = false;
                        break;
                    case 'recoveryCode':
                        this.login = false;
                        this.register = false;
                        this.recovery = false;
                        this.registerCode = false;
                        this.recoveryCode = true;
                        break;
                }
            }
        }
    };
</script>

<style scoped>
  .modaler {
    width: 100%;
    height: 100%;
    background: rgba(50, 50, 50, 0.9);
    position: fixed;
    top: 0;
    left: 0;
    z-index: 100;
  }
</style>