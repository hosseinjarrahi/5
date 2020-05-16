<template>

  <div class="row justify-content-center my-3">
    <div class="col-11 my-2 bg-dark-gray rounded">

      <div class="d-flex p-2 flex-md-row flex-column text-center">

        <div class="p-1 bg-light mx-2 rounded d-none d-md-flex"></div>
        <h2 class="p-0 m-0">{{ room.name }}</h2>
        <div class="dropdown-divider d-block d-md-none"></div>
        <div class="d-flex ml-md-auto align-items-center flex-column flex-md-row ">
          <div class="mx-3"><span>کد عضویت : </span><span>{{ room.code }}</span></div>
          <div class="dropdown-divider d-block d-md-none"></div>
          <div class="mx-3"><span>تعداد اعضاء : </span><span>{{ room.members.length }}</span></div>
          <div class="dropdown-divider d-block d-md-none"></div>
          <div class="mx-3"><span>ساخته شده در : </span><span>{{ createdat }}</span></div>
        </div>
      </div>

    </div>
  </div>

</template>

<script>
    export default {
        name: "AppPanelRoomInfo",
        props: {
            room: {default:null},
            createdat:{default:''}
        }
    }
</script>

<style scoped>

</style>
