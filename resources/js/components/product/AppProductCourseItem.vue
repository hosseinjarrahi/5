<template>
  <div class="container">
    <div
      class="row position-relative p-2 align-items-center"
      style="border-bottom:1px solid #f5f5f5;margin-top:20px;"
    >
      <div class="test-center item-circle circle d-flex align-items-center justify-content-center">
        <span v-if="item.free">{{ index }}</span>
        <span v-else class="fas fa-lock"></span>
      </div>
      <div class="col-12 col-md-8 px-5 my-3 my-md-0">
        <span class="text-white">{{ item.title }}</span>
        <span class="text-white badge badge-success p-1 rounded" v-if="item.free">رایگان</span>
      </div>
      <div class="col-6 col-md-2 text-right" style="height:30px;overflow:auto;">
        <span class="fas fa-clock"></span>
        <span>{{ item.time }}</span>
      </div>
      <div class="col-6 col-md-2 text-right" style="height:30px;overflow:auto;">
        <span class="btn bg-light py-0">
          <a :href="`/file?hash=${item.hash}`"><span class="fas fa-download"></span></a>
        </span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    props:{
        item:{default:''},
        index:{default:''},
    }
};
</script>

<style scoped>
.item-circle {
  position: absolute;
  border: 2px #f5f5f5 solid;
  top: 3px;
  right: 0;
  width: 40px;
  height: 40px;
}
</style>
