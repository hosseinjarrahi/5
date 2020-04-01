<template>
  <div class="w-100 position-relative">
    <div class="w-100 bg-dark-gray px-3 box text-justify text-white">
      <p>متن ما این است داداش</p>
    </div>

    <div class="avatar-parent">
      <div class="avatar circle bg-dark-gray shadow" style="background-image:url(/img/admin.png)"></div>
    </div>

    <div class="time">
      <div class="time-item badge bg-gray text-white shadow">
        2 روز قبل
      </div>
    </div>

  </div>
</template>

<script>
    export default {
        name: "AppNotificationBox"
    }
</script>

<style scoped>
.box{
  border: 5px solid white;
  box-shadow: 0px 5px 5px rgba(0,0,0,0.8);
  border-radius: 10px;
  padding-top: 40px;
}
.avatar-parent,.time {
  position: absolute;
  top: -30px;
  width: 100%;
  display: flex;
  left: 0;
  right: 0;
  justify-content: center;
}
.avatar {
  width: 70px;
  height: 70px;
  background-size: cover;
  background-position: center;
  border: 2px solid white;
}
 .time{
   top: 0px;
   width: 100%;
   display: flex;
   left: 0;
   padding-left: 10px;
   padding-top: 10px;
   justify-content: flex-end;
 }
</style>