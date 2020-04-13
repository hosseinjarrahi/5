<template>
  <div>
    <textarea v-model="formula" name="desc" class="mb-5 form-control" cols="30" rows="10"></textarea>
    <vue-mathjax :formula="formula"></vue-mathjax>
  </div>
</template>

<script>
    export default {
        data() {
            return {
                formula: '$$x = {-b \\pm \\sqrt{b^2-4ac} \\over 2a}.$$',
            }
        }
    }
</script>

<style scoped>

</style>