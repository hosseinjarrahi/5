<template>
  <div class="modaler">
    <div class="modal-dialog" style="overflow: hidden" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <transition name="fade" v-if="!auth">
            <h5 class="modal-title" key="a" v-if="loginer">فرم ورود</h5>

            <h5 class="modal-title" key="b" v-else-if="register">فرم ثبت نام</h5>

            <h5 class="modal-title" key="c" v-else-if="recovery">فرم بازیابی</h5>

            <h5 class="modal-title" key="d" v-else-if="recoveryCode">کد تایید</h5>
          </transition>

          <button type="button" class="close" @click="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <app-error-list :errors="errors"/>

          <transition name="fade" mode="out-in" v-if="!auth">
            <div v-if="loginer" key="login">
              <form>
                <div class="form-group">
                  <span class="fas fa-user"></span>
                  <span>تلفن و یا ایمیل:</span>
                  <input v-model="login.variable" type="text" class="form-control"/>
                </div>
                <div class="form-group">
                  <span class="fas fa-eye"></span>
                  <span>رمز عبور:</span>
                  <input v-model="login.password" type="password" class="form-control"/>
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
                <a
                  href
                  type="button"
                  class="btn btn-primary"
                  @click.prevent="changeState('register')"
                >
                  <span class="fas fa-plus"></span>
                  <span>ثبت نام</span>
                </a>
              </div>
            </div>

            <div v-if="register" key="register">
              <form>
                <div class="form-group">
                  <span class="fas fa-phone"></span>
                  <span>شماره تلفن</span>
                  <span>و یا ایمیل</span>
                  <input
                    v-model="registerForm.phone"
                    class="form-control"
                    type="text"
                    required
                    min="10"
                  />
                </div>
                <div class="form-group">
                  <span class="fas fa-pen"></span>
                  <span>نام و نام خانوادگی</span>
                  <input v-model="registerForm.name" class="form-control" type="text" required/>
                </div>
                <div class="form-group">
                  <span class="fas fa-eye"></span>
                  <span>رمز عبور</span>
                  <input
                    v-model="registerForm.password"
                    class="form-control"
                    type="password"
                    required
                    min="8"
                    max="36"
                  />
                </div>
                <div class="form-group">
                  <span class="fas fa-eye"></span>
                  <span>تکرار رمز عبور</span>
                  <input
                    v-model="registerForm.confirm"
                    class="form-control"
                    type="password"
                    required
                    min="8"
                    max="36"
                  />
                </div>
                <div class="form-group d-flex align-items-center justify-content-around mb-3">
                  <div
                    :class="['btn bg-dark-gray',{active:registerForm.type == 'teacher'}]"
                    @click="registerForm.type = 'teacher'"
                  >
                    <span class="fas fa-chalkboard-teacher"></span>
                    <span>معلم هستم</span>
                  </div>
                  <div
                    class="circle bg-dark-gray d-flex justify-content-center align-items-center"
                    style="width:30px;height:30px;"
                  >?
                  </div>
                  <div
                    :class="['btn bg-dark-gray',{active:registerForm.type == 'student'}]"
                    @click="registerForm.type = 'student'"
                  >
                    <span class="fas fa-child"></span>
                    <span>دانش آموز هستم</span>
                  </div>
                </div>
                <button class="btn btn-primary btn-block" @click.prevent="doRegister">ارسال کد تایید</button>
              </form>
            </div>

            <div v-if="registerCode" key="registerCode">
              <form>
                <p class="text-center">
                  <span>کد ارسال شده به </span>
                  <b>{{ registerForm.phone }}</b>
                  <span>را وارد کنید</span>
                </p>
                <div class="form-group">
                  <span class="fas fa-check-circle"></span>
                  <span>کد تایید</span>
                  <input v-model="verifyCode" class="form-control" type="text" required/>
                </div>
                <button @click.prevent="verify" class="btn btn-primary">ارسال کد تایید</button>
              </form>
            </div>

            <div v-if="recovery" key="recovery">
              <form>
                <div class="form-group">
                  <b>در هر روز تنها یکبار از طریق تلفن امکان بازیابی وجود دارد.</b>
                  <hr/>
                  <span class="fas fa-phone"></span>
                  <span>تلفن همراه و یا ایمیل:</span>
                  <input v-model="phone" type="text" class="form-control"/>
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
    import Swal from "sweetalert2";

    export default {
        created() {
            this.auth = window.EventBus.auth;
        },
        data() {
            return {
                auth: null,
                loginer: true,
                register: false,
                recovery: false,
                registerCode: false,
                recoveryCode: false,
                verifyCode: "",
                phone: "",
                registerForm: {
                    phone: "",
                    name: "",
                    type: "",
                    password: "",
                    confirm: ""
                },
                login: {
                    variable: "",
                    password: ""
                },
                errors: []
            };
        },
        methods: {
            close() {
                this.$emit("close");
            },
            doLogin() {
                this.errors = [];
                this.load();
                axios.post("/login", this.login)
                    .then(response => {
                        Swal.fire({
                            text: response.data.message,
                            icon: "success",
                            confirmButtonText: "بسیار خوب",
                            timer: 5000
                        });
                        location.reload();
                    })
                    .catch(err => {
                        this.errors = err.response.data.errors;
                        if (this.errors.length > 0 && err.response.data.message) {
                            Swal.fire({
                                text: err.response.data.message,
                                icon: "error",
                                confirmButtonText: "بسیار خوب",
                                timer: 5000
                            });
                        }
                    })
                    .then( () => {
                        this.closeLoad();
                    });
            },
            doRegister() {
                this.errors = [];
                this.load();
                axios
                    .post("/register", this.registerForm)
                    .then(response => {
                        Swal.fire({
                            text: response.data.message,
                            icon: response.data.type,
                            confirmButtonText: "بسیار خوب",
                            timer: 5000
                        });
                        this.changeState("registerCode");
                        this.registerForm = {phone: "", name: "", type: "", password: "", confirm: ""};
                    })
                    .catch(err => {
                            this.errors = err.response.data.errors;
                            if (err.response.data.message) {
                                Swal.fire({
                                    text: err.response.data.message,
                                    icon: "error",
                                    confirmButtonText: "بسیار خوب",
                                    timer: 5000
                                });
                            }
                        }
                    )
                    .then( () => {
                        this.closeLoad();
                    });
            },
            verify() {
                this.errors = [];
                this.load();
                axios
                    .post("/verify", {verify: this.verifyCode})
                    .then(response => {
                        Swal.fire({
                            text: response.data.message,
                            icon: 'success',
                            confirmButtonText: "بسیار خوب",
                            timer: 5000
                        });

                        this.changeState("login");
                        setTimeout(()=>{window.location.reload();},1000);
                    })
                    .catch(err => {
                        Swal.fire({
                            text: 'error',
                            icon: "error",
                            confirmButtonText: "بسیار خوب",
                            timer: 5000
                        });
                    })
                    .then( () => {
                        this.closeLoad();
                    });
            },
            sendCode() {
                this.errors = [];
                this.load();
                axios
                    .post("/reset-password", {phone: this.phone})
                    .then(res => {
                        Swal.fire({
                            text:
                                "اگر شماره تلفن و یا ایمیل را درست وارد کرده باشید کد برای شما ارسال شده است.",
                            icon: "success",
                            confirmButtonText: "بسیار خوب",
                            timer: 5000
                        });
                        this.$emit("close");
                    })
                    .catch(err => {
                        let message =
                            err.response.data.message ?
                                err.response.data.message :
                                "تعداد درخواست های شما بیش از حد مجاز است.";
                        this.errors = err.response.data.errors;
                        if (!this.errors)
                            Swal.fire({
                                text: message,
                                icon: "error",
                                confirmButtonText: "بسیار خوب",
                                timer: 5000
                            });
                    })
                    .then( () => {
                        this.closeLoad();
                    });
            },
            changeState(s) {
                this.errors = [];
                switch (s) {
                    case "login":
                        this.loginer = true;
                        this.register = false;
                        this.recovery = false;
                        this.registerCode = false;
                        this.recoveryCode = false;
                        break;
                    case "register":
                        this.loginer = false;
                        this.register = true;
                        this.recovery = false;
                        this.registerCode = false;
                        this.recoveryCode = false;
                        break;
                    case "recovery":
                        this.loginer = false;
                        this.register = false;
                        this.recovery = true;
                        this.registerCode = false;
                        this.recoveryCode = false;
                        break;
                    case "registerCode":
                        this.loginer = false;
                        this.register = false;
                        this.recovery = false;
                        this.registerCode = true;
                        this.recoveryCode = false;
                        break;
                    case "recoveryCode":
                        this.loginer = false;
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

  .active {
    background-color: #e20;
  }
</style>