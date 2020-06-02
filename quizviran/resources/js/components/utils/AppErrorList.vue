<template>
  <div class="my-2 text-danger container-fluid">
    <p class="alert-danger alert" v-for="(error,index) in errors" :key="index">{{ error[0] }}</p>
  </div>
</template>

<script>
export default {
  props: ["errors"]
};
</script>

<style>
</style>