<template>
  <div class="my-2 rounded " style="border:1px solid #f5f5f5">
    <div class="d-flex flex-column flex-md-row">
      <span class="m-2 p-2 text-white">
          <span class="fas fa-download"></span>
          <a href=""> دانلود </a>
      </span>
      <span class="m-2 p-2 text-white">
          <span class="fas fa-file"></span>
          <span> نوع فایل: </span>
          <span> pdf </span>
      </span>
      <span class="m-2 p-2 text-white">
          <span class="fas fa-box"></span>
          <span> حجم: </span>
          <span> 2Mb </span>
      </span>
    </div>
  </div>
</template>

<script>
    export default {
        name: "AppDownloadBox"
    }
</script>

<style scoped>

</style>