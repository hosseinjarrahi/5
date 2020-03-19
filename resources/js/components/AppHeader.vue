<template>
  <div class="container-fluid p-0 fix">
    <transition name="fade">
      <app-modal v-if="openModal" @close="openModal = false"></app-modal>
    </transition>
    <div class="container-fluid head-color">
      <nav class="container navbar navbar-expand text-center navbar-light py-md-0 py-2">
        <div
          class="collapse position-relative navbar-collapse navbar-expand-md align-items-center justify-content-start"
          id="navbarNav"
        >
          <a class="position-absolute" style="left:40px">
            <img
              src="/img/user.png"
              height="50"
              class="d-inline-block"
              alt="user avatar"
              @click="openModal =!openModal"
            />
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
            <li class="nav-item">
              <a class="nav-link text-white" href="http://tizviran.com">خانه</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="http://quiz.tizviran.com">صفحه اصلی</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="http://forum.tizviran.com">انجمن</a>
            </li>
          </ul>

        </div>
      </nav>
      <ul class="navbar-nav d-flex flex-column p-3" v-if="opened">
        <li class="nav-item">
          <a class="nav-link text-white" href="http://tizviran.com">خانه</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="http://quiz.tizviran.com">صفحه اصلی</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="http://forum.tizviran.com">انجمن</a>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
    export default {
        data() {
            return {
                opened: false,
                openModal: false,
                scroll: false
            };
        },
        methods: {},
    };
</script>

<style scoped lang="scss">
  @import "./../../sass/app.scss";

  @media screen and (max-width: 768px) {
  }

  .red {
    color: $red !important;
  }

  .head-color {
    background: $darkGray;
  }

  .fix {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 5;
  }
</style>
