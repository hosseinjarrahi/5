<template>
  <div class="w-100 text-center shadow bg-dark-gray rounded d-flex justify-content-center flex-column flex-md-row">

    <a href="#" class="item px-3 py-3 py-md-2 text-white">
        ریاضی هفتم
    </a>

    <a href="#" class="item px-3 py-3 py-md-2 text-white">
        ریاضی هفتم
    </a>

    <a href="#" class="item px-3 py-3 py-md-2 text-white">
        ریاضی هفتم
    </a>

    <a href="#" class="item px-3 py-3 py-md-2 text-white">
        ریاضی هفتم
    </a>

    </div>
</template>

<script>
export default {
  data(){
    return{
      categories:[
        {name:'one',to:'to'},
        {name:'one',to:'to'},
        {name:'one',to:'to'},
        {name:'one',to:'to'},
        {name:'one',to:'to'},
        {name:'one',to:'to'},
      ]
    }
  }
}
</script>

<style lang="scss">
  @import "./../../../sass/app.scss";
.item{
  transition: all 0.5s;
}
.item:hover{
  background-color: $backgroundColor;
  color: $darkGray !important;
}

</style>