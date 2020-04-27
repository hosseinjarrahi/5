<template>
  <div class="row py-2 rounded position-relative justify-content-center app-border-box">
    <div class="d-flex justify-content-center position-absolute" style="top:-18px;">
      <div class="title app-border-box px-3 py-1 rounded font-weight-bold">
        <span :class="'fas fa-'+icon"></span>
        {{ title }}
      </div>
    </div>
    <div class="pt-3 container">
      <slot></slot>
    </div>
  </div>
</template>

<script>
    export default {
        props: {
            title: {default: ''},
            icon: {default: ''},
        }
    }
</script>

<style scoped>
  .title {
    color: #2f3542;
    background-color: #f5f5f5;
  }
</style>