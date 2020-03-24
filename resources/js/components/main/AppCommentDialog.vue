<template>
  <div class="w-100">
    <form action="">
      <textarea class="form-control add-comment-bg" name="" id="" rows="10"></textarea>
    </form>
  </div>
</template>

<script scoped>

export default {

}
</script>

<style scoped lang="scss">
@import "./../../../sass/app.scss";

.add-comment-bg{
  background-color: $gray;
}

.add-comment-bg:focus{
  background-color: $gray !important;
  border-color: $darkGray !important;
  box-shadow: 0px 2px 5px $darkGray;
}
</style>