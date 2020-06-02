<template>
  <div class="row flex-md-row flex-column bg-dark-gray py-3 rounded">

    <div class="col-md-9 d-flex flex-row">

      <div class="bg-light p-1 rounded"></div>
      <div class="d-flex flex-column ml-4 justify-content-center">
        <div class="row">
          <h2>آزمون بزرگ</h2>
        </div>
        <div class="row">
          <span class="badge badge-light mx-1">پایه هشتم</span>
          <span class="badge badge-light mx-1">زمان آزمون : 45 دقیقه</span>
        </div>
      </div>

    </div>

    <div class="col-md-3 d-flex flex-column mt-2 mt-md-0">

      <div class="btn my-1 btn-light">ورود به آزمون</div>
      <div class="my-1 border-light text-center rounded" style="border-bottom:2px solid">8 دقیقه تا شروع</div>

    </div>

    <div class="container-fluid rounded my-3 bg-gray" style="padding-top:1px"></div>

  </div>
</template>

<script>
    export default {
        name: "AppMainBoxLastQuiz"
    }
</script>

<style scoped>

</style>