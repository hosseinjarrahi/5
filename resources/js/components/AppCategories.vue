<template>
  <div v-if="categories.length" class="w-100 text-center shadow bg-dark-gray rounded d-flex justify-content-center flex-column flex-md-row">

    <a v-for="(cat,index) in categories"
       :key="index"
       :href="'/'+cat.slug"
       class="item px-3 py-3 py-md-2 text-white"
       v-text="cat.name">
    </a>

  </div>
</template>

<script>
  export default {
    props: {
      categories: {default: []}
    }
  }
</script>

<style lang="scss">
  @import "@sass/app.scss";

  .item {
    transition: all 0.5s;
  }

  .item:hover {
    background-color: $backgroundColor;
    color: $darkGray !important;
  }

</style>
