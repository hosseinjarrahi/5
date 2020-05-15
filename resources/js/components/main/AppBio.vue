<template>
  <div class="text-white bg-dark-gray shadow rounded position-relative" style="margin-top:60px;padding-top:50px;" v-if="teacher.profile">
    <div class="px-4" style="font-size:0.9rem">
        <div class="my-2 border-bottom-dark p-2 text-center">
          <span>{{ teacher.name }}</span>
        </div>

        <div class="my-2 border-bottom-dark p-2 text-justify">
          {{ teacher.profile.bio }}
        </div>
    </div>

    <slot name="avatar">
      <div class="avatar-parent">
        <div class="avatar circle bg-dark-gray shadow" :style="{backgroundImage:`url(${avatar})`}"></div>
      </div>
    </slot>
  </div>
</template>

<script>
export default {
  name: "AppProductDesc",
    props:{
      teacher:{default:''}
    },
    computed:{
      avatar(){
          if(this.teacher.profile.avatar)
              return this.teacher.profile.avatar;
          return '/img/avatar.svg';
      }
    }
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
.avatar {
  width: 100px;
  height: 100px;
  background-size: cover;
  background-position: center;
  border: 2px solid #57606f;
}
.border-bottom-dark {
  border-bottom: 2px solid #57606f;
}
</style>
