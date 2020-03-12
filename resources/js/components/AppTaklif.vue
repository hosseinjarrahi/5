<template>
  <div class="col-11 col-md-6 p-3 my-4">
    <div class="container-fluid bg p-3  shadow rounded posisoin-relative">
      <div class="w-100 parent d-flex justify-content-center">
        <div class="title p-2 px-4 shadow rounded"><h4>تکالیف</h4></div>
      </div>
      <div class="my-4">
            <slot></slot>
        </div>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style scoped>
.bg {
  background: #4e54c8; /* fallback for old browsers */
  background: -webkit-linear-gradient(
    to right,
    #8f94fb,
    #4e54c8
  ); /* Chrome 10-25, Safari 5.1-6 */
  background: linear-gradient(
    to right,
    #8f94fb,
    #4e54c8
  ); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
}
.parent {
  top: -10px;
  left: 0;
  position: absolute;
}
.title {
  background: #d3cce3; /* fallback for old browsers */
  background: -webkit-linear-gradient(
    to right,
    #e9e4f0,
    #d3cce3
  ); /* Chrome 10-25, Safari 5.1-6 */
  background: linear-gradient(
    to right,
    #e9e4f0,
    #d3cce3
  ); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
  margin: auto;
}
</style>
