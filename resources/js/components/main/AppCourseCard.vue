<template>
  <div class="p-2 col-12 col-md-4 position-relative" style="cursor: pointer">
    <div class="offer" v-if="offer">
      <img src="/img/offer.svg" class="img-fluid" alt="offer" />
    </div>
    <div class="my-2 rounded shadow course-card">
      <div
        class="course-header shadow rounded"
        style="background-image:url('/img/course-test.jpg');"
      ></div>

      <div class="p-3">
        <p
          class="text-justify"
          style="color:#f5f5f5;"
        >دوره آموزش متوسط ریاضی هشتم بدون در نظر گرفتم عدد جرمی</p>

        <slot name="avatar">
          <p class="border-bottom border-light pb-2 text-white">
            <span>
              <img src="/img/avatar.png" class="shadow avatar" alt />
              <span>استاد:</span>
              <span>جعفری</span>
            </span>
          </p>
        </slot>

        <slot name="footer">
          <div class="d-flex flex-row justify-content-between align-items-center">
            <span>
              <span class="fas fa-clock"></span>
              <span>12:40:20</span>
            </span>

            <span>
              <span class="btn btn-success py-0" v-if="offer">
                <span>{{  offer }}</span>
              </span>
              <span class="btn bg-dark-gray py-0">
                <span :class="{'line-throgh':offer}">19.000</span>
              </span>

            </span>
            

          </div>
        </slot>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "AppCourseCard",
  props: {
    offer: { default: null }
  }
};
</script>

<style scoped>
.course-header {
  padding-top: 50%;
  background-position: center;
  background-size: cover;
}
.course-card {
  background-color: #57606f;
  border: 1px dashed #f5f5f5;
}
.offer {
  position: absolute;
  top: 1px;
  left: 1px;
  width: 50px;
  height: 50px;
}
.avatar {
  width: 30px;
  height: 30px;
  border-radius: 100%;
}
.line-throgh{
  text-decoration: line-through red;
}
</style>