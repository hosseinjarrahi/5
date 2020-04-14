<template>
  <header class="container-fluid p-0 fix">

    <app-event v-if="event.show" v-html="event.body"></app-event>

    <transition name="fade">
      <app-login-modal v-if="openModal && !auth" @close="openModal = false"></app-login-modal>
    </transition>
    <div class="container-fluid head-color">
      <nav class="container navbar navbar-expand text-center navbar-light py-md-0 py-2">
        <div
          class="collapse position-relative navbar-collapse navbar-expand-md align-items-center justify-content-start"
          id="navbarNav"
        >
          <a class="position-absolute" @click="openModal =!openModal" style="left:40px;cursor:pointer">
            <span class="text-white" v-if="!auth">ورود / ثبت نام</span>
            <span class="text-white" v-else><span class="fas fa-angle-down"></span></span>
            <img
              src="/img/user.png"
              height="50"
              class="d-inline-block"
              alt="user avatar"
            />
            <transition name="slide">
              <div class="dropdown" v-if="openModal && auth">
                <div class="dropdown-menu d-block" style="left:-50px">
                  <a class="dropdown-item" href="/notifications">
                    <span class="fas fa-bell mr-1 position-relative">
                      <span class="position-absolute badge badge-info" style="top: -10px;right:-5px;font-size:0.6rem">{{ notifications }}</span>
                    </span>اعلانات
                  </a>
                  <!-- <a class="dropdown-item" href="/purchases"><span class="fas fa-shopping-bag mr-1"></span>خرید ها</a> -->
                  <a class="dropdown-item" href="/profile"><span class="fas fa-user-alt mr-1"></span>پروفایل</a>
                  <a class="dropdown-item text-danger" href="/logout"><span class="fas fa-door-open mr-1"></span>خروج</a>
                </div>
              </div>
            </transition>
          </a>

          <div
            class="d-flex d-md-none border border-white text-white p-2 position-absolute"
            style="cursor:pointer;transform:rotate(90deg);left:0"
            @click="opened = !opened"
          >
            <span>|||</span>
          </div>

          <a class="navbar-brand" href="/">
            <img src="/img/logo.png" height="30" class="d-inline-block align-top" alt/>
          </a>

          <ul class="navbar-nav d-none d-md-flex align-items-center">
            <li class="nav-item" v-for="(link,index) in links" :key="index">
              <a class="nav-link text-white" :href="link.to">{{ link.title }}</a>
            </li>
          </ul>

        </div>
      </nav>
      <ul class="navbar-nav d-flex flex-column p-3" v-if="opened">
        <li class="nav-item" v-for="(link,index) in links" :key="index">
          <a class="nav-link text-white" :href="link.to">{{ link.title }}</a>
        </li>
      </ul>
    </div>
  </header>
</template>

<script>
    export default {
        props: {
            notifications: {default: 0},
            event: {default: 0},
        },
        data() {
            return {
                opened: false,
                openModal: false,
                scroll: false,
                auth: window.EventBus.auth,
                links: [
                    {to: '/', title: 'خانه'},
                    {to: '/quiz', title: 'کوییزویران'},
                    {to: '/فروشگاه', title: 'فروشگاه'},
                    {to: 'http://forum.tizviran.com', title: 'انجمن'},
                ]
            };
        },
        methods: {},
    };
</script>

<style scoped>

  @media screen and (max-width: 768px) {
  }

  .red {
    color: #df0000 !important;
  }

  .head-color {
    background: #2f3542;
  }

  .fix {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 5;
  }
</style>
