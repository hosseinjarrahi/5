<template>
  <div class="row justify-content-around">
    <a href="/quiz/panel/rooms" class="mb-1 link-hover p-2">کلاس ها</a>
    <a href="/quiz/panel/room/create" class="mb-1 link-hover p-2" v-if="type == 'teacher'">ایجاد کلاس</a>
    <a href="/quiz/panel/exams" class="mb-1 link-hover p-2" v-if="type == 'student'">آزمون ها</a>
    <a href="/quiz/panel/join-class" class="mb-1 link-hover p-2" v-if="type == 'student'">عضویت در کلاس</a>
    <a class="mb-1 link-hover p-2 position-relative" v-if="type == 'teacher'">
      <span>گفت و گو ها</span>
      <span class="badge badge-primary position-absolute"
            style="top: -7px;left: -15px;transform: rotate(-30deg)">به زودی
      </span>
    </a>
  </div>
</template>

<script>
    export default {
        name: "AppPanelLinksHeader",
        props:['type']
    }
</script>

<style scoped>

</style>