<template>
  <div class="text-white bg-dark-gray shadow rounded position-relative" style="padding-top:65px;">

    <div class="px-4" style="font-size:0.9rem">

      <div class="my-2 border-bottom-dark p-2">
        <span class="fas fa-chalkboard-teacher"></span>
        <span>نام استاد : </span>
        <span>محمد رضا فهیمی</span>
      </div>

      <div class="my-2 border-bottom-dark p-2">
        <span class="fas fa-file-video"></span>
        <span>جلسات منتشر شده : </span>
        <span>50 قسمت</span>
      </div>

      <div class="my-2 border-bottom-dark p-2">
        <span class="fas fa-clock"></span>
        <span>زمان دوره : </span>
        <span>20:50:10</span>
      </div>

      <div class="my-2 border-bottom-dark p-2">
        <span class="fas fa-user-graduate"></span>
        <span>تعداد شرکت کنندگان : </span>
        <span>20</span>
        <span>نفر</span>
      </div>

      <div class="my-2 border-bottom-dark p-2">
        <span class="fas fa-spinner"></span>
        <span>وضعیت دوره : </span>
        <span>کامل</span>
      </div>

      <div class="my-2 border-bottom-dark p-2">
        <span class="fas fa-percentage"></span>
        <span>درصد تکمیل : </span>
        <span class="my-2">
          <div class="progress">
            <div class="progress-bar" style="width: 25%">25%</div>
          </div>
        </span>
      </div>

    </div>

    <div class="avatar-parent">
      <div class="avatar bg-light circle p-2 white-shadow"></div>
    </div>

  </div>
</template>

<script>
export default {
  name:'AppProductDesc'
};
</script>

<style scoped>
.avatar-parent{
  position: absolute;
  top: -50px;
  width: 100%;
  display: flex;
  justify-content: center;
}
.avatar{
  width: 100px;
  height:100px;
  background-image:url('/img/avatar.png');
  background-size: cover;
  background-position: center;
  border: 2px solid #57606f; 
}
.border-bottom-dark{
  border-bottom: 2px solid #57606f;
}
</style>