<template>
  <div class="row justify-content-center mb-3">
    <div class="d-block w-100 divider"></div>

    <div class="col-12 border-sm bg-dark-gray py-2 py-lg-0">
      <a :href="route" class="text-light d-flex justify-content-end p-2 align-items-center flex-row">
        <span>بازگشت</span>
        <span class="fas fa-arrow-left fa-fw mx-1"></span>
      </a>
    </div>
  </div>
</template>

<script>
    export default {
        name: "AppBack",
        props: ['route']
    }
</script>

<style scoped>

</style>
