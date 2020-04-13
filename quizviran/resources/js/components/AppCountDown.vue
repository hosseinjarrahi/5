<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="counter p-2 px-4 rounded shadow text-white">
        <span>{{ time }}</span>
        <span>دقیقه تا پایان</span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      time:this.min
    };
  },
  methods: {},
  props: {
    min: { default: 0 }
  },
  created() {
    setInterval(() => {
      this.time -= 1;
    }, 1000 * 60);
  }
};
</script>

<style scoped>
.counter {
  position: fixed;
  bottom: 0;
  background: #f12711; /* fallback for old browsers */
  background: -webkit-linear-gradient(
    to right,
    #f5af19,
    #f12711
  ); /* Chrome 10-25, Safari 5.1-6 */
  background: linear-gradient(
    to right,
    #f5af19,
    #f12711
  ); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
}
</style>
