<template>
  <a class="badge shadow badge-light" :href="'/tag/'+link">
    <slot></slot>
  </a>
</template>

<script>
export default {
  props:['link']
}
</script>

<style scoped>
</style>