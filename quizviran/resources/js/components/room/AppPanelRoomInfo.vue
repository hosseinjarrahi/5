<template>

  <div class="row justify-content-center mb-3">
    <div class="d-block w-100 divider"></div>

    <div class="col-12 border-sm bg-dark-gray py-2 py-lg-0">
      <div class="d-flex p-2 align-items-lg-center flex-md-row flex-column">

        <a :href="`/quiz/panel/room/${room.link}`" class="p-0 mx-2 my-0" style="font-size:1.2rem">
          <span class="fas fa-chalkboard-teacher fa-fw"></span>
          <span>{{ room.name }}</span>
        </a>

        <div class="dropdown-divider d-block d-md-none"></div>
        <div class="d-flex ml-md-auto flex-column flex-md-row " style="font-size:0.9rem">
          <div class="mx-3"><span class="fas fa-key fa-fw mx-2"></span><span>کد عضویت : </span><span>{{ room.code }}</span></div>
          <div class="dropdown-divider d-block d-md-none"></div>
          <div class="mx-3"><span class="fas fa-users fa-fw mx-2"></span><span>تعداد اعضاء : </span><span>{{ room.members.length }}</span></div>
          <div class="dropdown-divider d-block d-md-none"></div>
          <div class="mx-3"><span class="fas fa-calendar-check mx-2 fa-fw"></span><span>ساخته شده در : </span><span>{{ createdat }}</span></div>
        </div>
      </div>
    </div>

  </div>

</template>

<script>
    export default {
        name: "AppPanelRoomInfo",
        props: {
            room: {default: null},
            createdat: {default: ''}
        }
    }
</script>

<style scoped>
  @media only screen and (max-width: 992px) {
    .border-sm{
      border-radius:0px 0px 25px 25px !important;
    }
  }
</style>
