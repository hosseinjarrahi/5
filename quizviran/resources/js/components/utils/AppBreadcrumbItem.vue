<template>
  <span>
    <a :href="route" class="p-2" v-if="!active">
    <span><slot></slot></span>
  </a>
  <span class="p-2" v-else>
    <span><slot></slot></span>
  </span>
  <span class="fas fa-angle-left" v-if="!active"></span>
  </span>
</template>

<script>
    export default {
        name: "AppBreadcrumbItem",
        props: {
            route: {default: '#'},
            active: {default: false}
        }
    }
</script>

<style scoped>

</style>
