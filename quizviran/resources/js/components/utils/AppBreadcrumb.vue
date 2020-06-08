<template>
  <div class="row overflow-hidden bg-dark-gray align-items-center figure-caption text-light"
       style="height: 40px;overflow-x: auto;overflow-y: hidden;">
    <div class="col-12 divider"></div>
    <div class="col-12 py-2"><slot></slot></div>
  </div>
</template>

<script>
    export default {
        name: "AppBreadcrumb"
    }
</script>

<style scoped>

</style>
