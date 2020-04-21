<template>
  <div style="z-index: 5000;">
    <div :class="[menu ? 'menu' : 'menu close']" ref="menu">
      <div class="mb-5 bg-info px-4 rounded shadow text-center">
        پنل مدیریت
      </div>

      <ul class="m-0 p-0 d-flex flex-column justify-content-center text-center">
        <li><a href="/manager/product">محصولات</a></li>
        <li><a href="/manager/category">دسته بندی ها</a></li>
        <li><a href="/manager/slide">اسلایدر</a></li>
        <li><a href="/manager/event">رویدادها</a></li>
        <li><a href="/manager/payment">خریدها</a></li>
        <li><a href="/manager/user">کاربران</a></li>
        <li><a href="/manager/comment">نظرات</a></li>
        <li><a href="/manager/setting">تنظیمات</a></li>
      </ul>
    </div>

    <div class="button" @click="menu = !menu">
      <span class="border border-dark">|||</span>
    </div>
  </div>
</template>

<script>
    export default {
        data() {
            return {
                menu: true
            }
        },
    };
</script>

<style scoped>
  .menu {
    transition: all 0.5s;
    position: fixed;
    height: 100%;
    overflow: auto;
    right: 0;
    top: 0;
    width: 200px;
    background: #34495e;
    color: white;
    padding: 10px;
  }

  li {
    list-style-type: none;
    margin-top: 20px;
    transition: al 0.5s;
    padding: 5px 30px;
  }

  li:hover {
    background: #f5f5f5;
    border-radius: 10px;
    box-shadow: 0px 0px 5px #f5f5f5;
    color: #34495e;
  }

  .button {
    cursor: pointer;
    position: fixed;
    left: -3px;
    top: 0px;;
    transform: rotate(90deg);
    background-color:#2c3e50;
    border-radius: 0px 50px 0px 0px;
    padding:20px;
    color:white;
  }

  .close {
    padding: 0;
    width: 0;
  }
</style>