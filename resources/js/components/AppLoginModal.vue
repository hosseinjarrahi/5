<template>
  <div class="modaler">
    <div class="modal-dialog" style="overflow: hidden" role="document">
      <div class="modal-content">
        <div class="modal-header">

          <transition name="fade" v-if="!auth">

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

          <transition name="fade" mode="out-in" v-if="!auth">
            <div v-if="login" key="login">
              <form>
                <div class="form-group">
                  <span class="fas fa-user"></span>
                  <span>نام کاربری:</span>
                  <input v-model="login.username" type="text" name="username" class="form-control"/>
                </div>
                <div class="form-group">
                  <span class="fas fa-eye"></span>
                  <span>رمز عبور:</span>
                  <input v-model="login.password" type="password" name="password" class="form-control"/>
                </div>
                <a href class="forget password p-2 mb-2" @click.prevent="changeState('recovery')">
                  <span class="fas fa-question"></span>
                  <span>فراموشی رمز عبور</span>
                </a>
                <button class="btn btn-primary btn-block my-2" @click.prevent="doLogin()">
                  <span class="fas fa-door-open"></span>
                  <span>ورود</span>
                </button>
              </form>

              <div class="modal-footer">
                <a href type="button" class="btn btn-primary" @click.prevent="changeState('register')">
                  <span class="fas fa-plus"></span>
                  <span>ثبت نام</span>
                </a>
              </div>
            </div>

            <div v-if="register" key="register">
              <form>
                <div class="my-2 text-danger">
                  <p class="alert-danger alert" v-for="(error,index) in errors" :key="index">{{ error[0] }}</p>
                </div>
                <div class="form-group">
                  <span class="fas fa-phone"></span>
                  <span>شماره تلفن</span>
                  <input v-model="registerForm.phone" name="phone" class="form-control" type="text" required min="10">
                </div>
                <div class="form-group">
                  <span class="fas fa-pen"></span>
                  <span>نام و نام خانوادگی</span>
                  <input v-model="registerForm.name" name="name" class="form-control" type="text" required>
                </div>
                <div class="form-group">
                  <span class="fas fa-user"></span>
                  <span>نام کاربری</span>
                  <input v-model="registerForm.handle" name="handle" class="form-control" type="text" required min="4" max="36">
                </div>
                <div class="form-group">
                  <span class="fas fa-eye"></span>
                  <span>رمز عبور</span>
                  <input v-model="registerForm.password" name="password" class="form-control" type="password" required min="8" max="36">
                </div>
                <div class="form-group">
                  <span class="fas fa-eye"></span>
                  <span>تکرار رمز عبور</span>
                  <input v-model="registerForm.confirm" name="confirm" class="form-control" type="password" required min="8" max="36">
                </div>
                <button class="btn btn-primary" @click.prevent="doRegister">ارسال کد تایید</button>
              </form>
            </div>

            <div v-if="registerCode" key="registerCode">
              <form>
                <p class="text-center">
                  <span>کد ارسال شده به شماره </span>
                  <b>{{ registerForm.phone }}</b>
                  <span> را وارد کنید </span>
                </p>
                <div class="form-group">
                  <span class="fas fa-check-circle"></span>
                  <span>کد تایید</span>
                  <input v-model="verifyCode" name="verify" class="form-control" type="text" required>
                </div>
                <button @click.prevent="verify" class="btn btn-primary">ارسال کد تایید</button>
              </form>
            </div>

            <div v-if="recovery" key="recovery">
              <form>
                <div class="form-group">
                  <b>در هر روز تنها یکبار امکان بازیابی رمز را دارید.</b>
                  <hr>
                  <span class="fas fa-phone"></span>
                  <span>تلفن:</span>
                  <input v-model="phone" type="text" name="username" class="form-control"/>
                </div>
                <button class="btn btn-primary btn-block my-2" @click.prevent="sendCode">ارسال کد</button>
              </form>
            </div>

          </transition>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
    import Swal from 'sweetalert2';

    export default {
        created() {
            this.auth = window.EventBus.auth;
        },
        data() {
            return {
                auth: null,
                login: true,
                register: false,
                recovery: false,
                registerCode: false,
                recoveryCode: false,
                verifyCode: '',
                phone: '',
                registerForm: {
                    phone: '',
                    name: '',
                    handle: '',
                    password: '',
                    confirm: '',
                },
                login: {
                    username: '',
                    password: ''
                },
                errors: []
            }
        },
        methods: {
            close() {
                this.$emit('close');
            },
            doLogin() {
                this.load();
                axios.post('/login', this.login)
                    .then(response => {
                        console.log(response.data.message);
                        Swal.fire({
                            text: response.data.message,
                            icon: response.data.type,
                            confirmButtonText: 'بسیار خوب',
                            timer: 5000
                        });
                        (response.data.type == 'success') ? location.reload() : '';
                    })
                    .catch(err => console.log(err));
                this.closeLoad();
            },
            doRegister() {
                this.load();
                axios.post('/register', this.registerForm)
                    .then(response => {
                        Swal.fire({
                            text: response.data.message,
                            icon: response.data.type,
                            confirmButtonText: 'بسیار خوب',
                            timer: 5000
                        });
                        if (response.data.type == 'success') {
                            this.changeState('registerCode');
                        }
                    })
                    .catch(err => {
                        this.errors = err.response.data.errors;
                    });
                this.closeLoad();
            },
            verify() {
                axios.post('/verify', {verify: this.verifyCode})
                    .then(response => {
                        Swal.fire({
                            text: response.data.message,
                            icon: response.data.type,
                            confirmButtonText: 'بسیار خوب',
                            timer: 5000
                        });
                        response.data.type == 'success' ? this.changeState('login') : null;

                    })
                    .catch(err => {
                        console.log(err);
                    });
            },
            sendCode() {
                this.load();
                axios.post('/send-code', {phone: this.phone})
                    .then(res => {
                        Swal.fire({
                            text: 'اگر شماره تلفن را درست وارد کرده باشید کد برای شما ارسال شده است.',
                            icon: 'success',
                            confirmButtonText: 'بسیار خوب',
                            timer: 5000
                        });
                        this.$emit('close');
                    })
                    .catch(err => {
                        Swal.fire({
                            text: 'تعداد درخواست های شما بیش از حد مجاز است.',
                            icon: 'error',
                            confirmButtonText: 'بسیار خوب',
                            timer: 5000
                        });
                    });
                this.closeLoad()
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
    z-index: 100050;
    overflow: auto;
  }
</style>