<template>
  <div class="modaler">
    <div class="modal-dialog" style="overflow: hidden" role="document">
      <div class="modal-content border-0 ">
        <div class="modal-header bg-dark-gray">
          <transition name="fade" mode="out-in" v-if="!auth">
            <h5 class="modal-title" key="a" v-if="status.login">فرم ورود</h5>

            <h5 class="modal-title" key="b" v-else-if="status.register">فرم ثبت نام</h5>

            <h5 class="modal-title" key="c" v-else-if="status.recovery">فرم بازیابی</h5>

            <h5 class="modal-title" key="d" v-else-if="status.recoveryCode">کد تایید</h5>
          </transition>

          <button type="button" class="text-white close" @click="toggleLoginModal">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <transition name="fade" mode="out-in">
            <div v-if="!status.login" @click="changeState('login')" class="pointer d-flex w-100 flex-row align-items-center justify-content-end">
              <span>بازگشت</span>
              <span class="mx-1 fas fa-arrow-left"></span>
            </div>
          </transition>

          <app-error-list :errors="errors"/>

          <transition name="fade" mode="out-in" v-if="!auth">
            <div v-if="status.login" key="login">
              <form>
                <div class="form-group">
                  <span class="fas fa-user"></span>
                  <span>تلفن و یا ایمیل:</span>
                  <input v-model="loginForm.variable" type="text" class="no-shadow form-control"/>
                </div>
                <div class="form-group">
                  <span class="fas fa-eye"></span>
                  <span>رمز عبور:</span>
                  <input v-model="loginForm.password" type="password" class="no-shadow form-control"/>
                </div>
                <a href class="forget password p-2 mb-2" @click.prevent="changeState('recovery')">
                  <span class="fas fa-question"></span>
                  <span>فراموشی رمز عبور</span>
                </a>
                <button class="btn btn-primary btn-block my-2" @click.prevent="doLogin(loginForm)">
                  <span class="fas fa-sign-in-alt"></span>
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

            <div v-if="status.register" key="register">
              <form>
                <div class="form-group">
                  <span class="fas fa-phone"></span>
                  <span>شماره تلفن</span>
                  <span>و یا ایمیل</span>
                  <input
                    v-model="registerForm.phone"
                    class="no-shadow form-control"
                    type="text"
                    required
                    min="10"
                  />
                </div>
                <div class="form-group">
                  <span class="fas fa-pen"></span>
                  <span>نام و نام خانوادگی</span>
                  <input v-model="registerForm.name" class="no-shadow form-control" type="text" required/>
                </div>
                <div class="form-group">
                  <span class="fas fa-eye"></span>
                  <span>رمز عبور</span>
                  <input
                    v-model="registerForm.password"
                    class="no-shadow form-control"
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
                    class="no-shadow form-control"
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
                <button class="btn btn-primary btn-block" @click.prevent="doRegister(registerForm)">ارسال کد تایید</button>
              </form>
            </div>

            <div v-if="status.registerCode" key="registerCode">
              <form>
                <p class="text-center">
                  <span>کد ارسال شده به </span>
                  <b>{{ registerForm.phone }}</b>
                  <span>را وارد کنید</span>
                </p>
                <div class="form-group">
                  <span class="fas fa-check-circle"></span>
                  <span>کد تایید</span>
                  <input v-model="verifyCode" class="no-shadow form-control" type="text" required/>
                </div>
                <button @click.prevent="verify(verifyCode)" class="btn btn-primary">ارسال کد تایید</button>
              </form>
            </div>

            <div v-if="status.recovery" key="recovery">
              <form>
                <div class="form-group">
                  <b>در هر روز تنها یکبار از طریق تلفن امکان بازیابی وجود دارد.</b>
                  <hr/>
                  <span class="fas fa-phone"></span>
                  <span>تلفن همراه و یا ایمیل:</span>
                  <input v-model="phone" type="text" class="no-shadow form-control"/>
                </div>
                <button class="btn btn-primary btn-block my-2" @click.prevent="sendCode(phone)">ارسال کد</button>
              </form>
            </div>
          </transition>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import {mapMutations} from 'vuex';
  import {mapActions} from 'vuex';
  import {mapGetters} from 'vuex';

  export default {
    created() {
      this.auth = window.EventBus.auth;
    },
    data() {
      return {
        auth: null,
        verifyCode: "",
        phone: "",
        registerForm: {
          phone: "",
          name: "",
          type: "",
          password: "",
          confirm: ""
        },
        loginForm: {
          variable: "",
          password: ""
        },
      };
    },
    computed: {
      ...mapGetters({
        errors: 'registerErrors',
        status: 'status',
      })
    },
    methods: {
      ...mapMutations([
        'toggleLoginModal',
        'setRegisterErrors'
      ]),
      ...mapActions([
        'changeState',
        'doLogin',
        'doRegister',
        'verify',
        'sendCode',
      ])
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
    background-color: #e20 !important;
  }
</style>
