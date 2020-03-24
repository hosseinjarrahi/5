<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="w-100">
          <div class="avatar-parent">
            <div class="avatar bg-light circle p-2 white-shadow"></div>
          </div>
          <span
            class="pl-5 pr-2 py-1 bg-dark-gray rounded w-100 w-md-auto"
            style="overflow:hidden"
          >یک مرد تنهسسسسسسسسسسسسای شب</span>
          <div class="my-3 p-3 bg-dark-gray rounded">
            <p style="white-space:pre">
              چرا اینجا اونجوری شد؟
              چرا اینجا اونجوری شد؟
              چرا اینجا اونجوری شد؟
              چرا اینجا اونجوری شد؟
              چرا اینجا اونجوری شد؟
              چرا اینجا اونجوری شد؟
              چرا اینجا اونجوری شد؟
              چرا اینجا اونجوری شد؟
              چرا اینجا اونجوری شد؟
              چرا اینجا اونجوری شد؟
              چرا اینجا اونجوری شد؟
            </p>

            <div class="tool-box">
              <span class="pointer fas fa-edit p-1 mx-1"></span>
              <span class="pointer text-danger fas fa-trash p-1 mx-1"></span>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style>
.avatar-parent {
  position: absolute;
  top: -15px;
  left: -5px;
  width: 100%;
  display: flex;
}
.avatar {
  width: 50px;
  height: 50px;
  background-image: url("/img/avatar.png");
  background-size: cover;
  background-position: center;
  border: 2px solid #57606f;
}
.tool-box {
  width: 100%;
  display: flex;
  justify-content: flex-end;
}
</style>