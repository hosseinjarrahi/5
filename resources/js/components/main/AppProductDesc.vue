<template>
  <div class="text-white bg-dark-gray shadow rounded position-relative" style="padding-top:150px;">
    <div class="px-4" style="font-size:0.9rem">
        <div class="my-2 border-bottom-dark p-2">
          <span class="fas fa-chalkboard-teacher"></span>
          <span>نام استاد :</span>
          <span>محمد رضا فهیمی</span>
        </div>

        <div class="my-2 border-bottom-dark p-2" v-if="product.courseItems.length">
          <span class="fas fa-file-video"></span>
          <span>فایل های منتشر شده :</span>
          <span>50</span>
        </div>

        <div class="my-2 border-bottom-dark p-2" v-if="product.time">
          <span class="fas fa-clock"></span>
          <span>زمان دوره :</span>
          <span>20:50:10</span>
        </div>

        <div class="my-2 border-bottom-dark p-2" v-if="product.downloadCount">
          <span class="fas fa-user-graduate"></span>
          <span>تعداد دانلود ها :</span>
          <span>20</span>
          <span>نفر</span>
        </div>

        <div class="my-2 border-bottom-dark p-2" v-if="product.status">
          <span class="fas fa-spinner"></span>
          <span>وضعیت دوره :</span>
          <span>{{ product.status }}</span>
        </div>

        <div class="my-2 border-bottom-dark p-2">
          <span class="fas fa-percentage"></span>
          <span>درصد تکمیل :</span>
          <span class="my-2">
            <div class="progress">
              <div class="progress-bar" :style="{width: `${product.percentage}%`}">{{ product.percentage }}%</div>
            </div>
          </span>
        </div>
    </div>

    <div class="avatar-parent">
      <div class="pic rounded bg-dark-gray shadow" style="background-image:url(/img/back.jpg)"></div>
    </div>
  </div>
</template>

<script>
export default {
  props:{
    product:{default:null}
  },
  name: "AppProductDesc",
  created() {
    console.log(this.product);
  },
};
</script>

<style scoped>
.avatar-parent {
  position: absolute;
  top: -50px;
  width: 100%;
  display: flex;
  left: 0;
  right: 0;
  justify-content: center;
}
.pic {
  width: 90%;
  height: 200px;
  background-image: url("/img/avatar.png");
  background-size: cover;
  background-position: center;
  border: 2px solid #57606f;
}
.border-bottom-dark {
  border-bottom: 2px solid #57606f;
}
</style>