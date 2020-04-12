<template>
  <div class="col-12">

    <div class="row text-danger flex-column mt-3">
      <div class="col-12 ">
        <h2 class="text-center">
          <span :class="[`fas fa-${icon}`]"></span>
          <span>{{ title }}</span>
        </h2>
        <div class="bg-danger p-1 rounded"></div>
      </div>
    </div>

    <div class="row mt-2">
      <div class="col-12">

        <slot></slot>

      </div>
    </div>

  </div>
</template>

<script>
    export default {
        props:['title','icon'],
        name: "AppMainBox"
    }
</script>

<style scoped>

</style>