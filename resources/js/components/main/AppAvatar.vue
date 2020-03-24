<template>
  <div class="avatar-parent">
    <div class="avatar bg-light circle p-2 white-shadow"></div>
  </div>
</template>

<script>
export default {
  props: {
    width: { default: "50" },
    img: { default: "" },
    pos: { default: "" }
  }
};
</script>

<style scoped>
.avatar-parent{
  position: absolute;
  width: 100%;
  
}
.avatar{
  width: 50px;
  height:50px;
  background-size: cover;
  background-position: center;
  border: 2px solid #57606f; 
}

</style>