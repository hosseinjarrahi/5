<template>
  <div class="row flex-md-row flex-column bg-dark-gray py-1 rounded">

    <div class="col-md-9 d-flex flex-row">

      <div class="bg-light p-1 rounded"></div>
      <div class="d-flex flex-column ml-4 justify-content-center">
        <div class="row">
          <h3>{{ exam.name }}</h3>
        </div>
        <div class="row">
          <!--          <span class="badge badge-light mx-1">پایه هشتم</span>-->
          <span class="badge badge-light mx-1">
            <span>زمان آزمون: </span>
            <span>{{ exam.time }}</span>
            <span>دقیقه</span>
          </span>
        </div>
      </div>

    </div>

    <div class="col-md-3 d-flex flex-column mt-2 mt-md-0">

      <a :href="exam.link" class="text-dark py-0 btn my-1 btn-light" v-if="exam.isInTime">ورود به آزمون</a>
      <a :href="exam.resultLink" class="text-dark py-0 btn my-1 btn-light">نتایج</a>
      <div class="my-1 border-light text-center rounded" style="border-bottom:2px solid">
        <span>زمان شروع:</span>
        <span>{{ exam.startJalaly }}</span>
      </div>

    </div>

    <div class="container-fluid rounded my-1 bg-gray" style="padding-top:1px"></div>

  </div>
</template>

<script>
    export default {
        name: "AppMainBoxLastQuiz",
        props: {
            exam: {default: ''}
        }
    }
</script>

<style scoped>

</style>
