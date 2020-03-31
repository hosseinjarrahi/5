<template>
  <div class="modaler">
    <div class="modal-dialog" style="overflow: hidden" role="document">
      <div class="modal-content border-0">
        <div class="modal-header bg-dark-gray text-white">
          <h5 class="modal-title">
          <span :class="['fas','fa-' + icon]"></span>
          {{ title }}
          </h5>

          <button type="button" class="close" @click="close">
            <span aria-hidden="true" class="text-white">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <slot></slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props:[
    'title',
    'icon',
  ],
  methods: {
    close() {
      this.$emit("close");
    }
  }
};
</script>

<style scoped>
.modaler {
  width: 100%;
  height: 100%;
  background: rgba(50, 50, 50, 0.9);
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1000;
  overflow: auto;
  color: darkslategray;
}
</style>