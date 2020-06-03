<template>
  <div class="invalid-feedback" v-if="errors">
    <slot>
      <div class="d-block" v-for="error in errors">
        {{ error }}
      </div>
    </slot>
  </div>
</template>

<script>
    export default {
        name: "AppErrors",
        props: {
            errors: {default: () => []}
        }
    }
</script>

<style scoped>

</style>
