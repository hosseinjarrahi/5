<template>
  <div style="padding: 1px" class="d-flex flex-row mx-2 align-items-center">
    <div class="circle bg-light"
         style="width: 90px;height: 90px;background-image:url()"
    ></div>
    <div class="d-flex flex-column">
      <div class="ml-1">
        {{ user.name }}
      </div>
      <div class="badge badge-light ml-1">
        <span>امتیاز:</span>
        <span>{{ user.point }}</span>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
        props:{
            user:{
                default:()=> ({name:'نام' , point: 400})
            }
        },
        name: "AppBestUsersItem"
    }
</script>

<style scoped>

</style>