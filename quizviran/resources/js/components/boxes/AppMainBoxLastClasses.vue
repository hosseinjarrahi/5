<template>
  <div class="row flex-md-row flex-column">

    <div class="col-md-9 d-flex flex-row">

      <div class="bg-light p-1 rounded"></div>
      <div class="d-flex flex-column ml-4 justify-content-center">
        <div class="row">
          <h4>{{ room.name }}</h4>
        </div>
        <div class="row">
          <span class="badge badge-light mx-1">
            <span>استاد:</span>
            <span>{{ room.user.name }}</span>
          </span>
        </div>
      </div>

    </div>

    <div class="col-md-3 d-flex align-items-center flex-column mt-2 mt-md-0">

      <a :href="room.link" class="btn my-1 btn-light btn-block py-0" style="color:#2f3542 !important;">ورود به کلاس</a>

    </div>

    <div class="container-fluid rounded my-1 bg-gray" style="padding-top:1px"></div>

  </div>
</template>

<script>
    export default {
        name: "AppMainBoxLastQuiz",
        props:{
            room:{default:''}
        }
    }
</script>

<style scoped>

</style>
