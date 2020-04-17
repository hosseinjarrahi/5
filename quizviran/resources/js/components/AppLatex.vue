<template>
  <div>
    <textarea v-model="formula" name="desc" class="mb-5 form-control" cols="30" rows="10"></textarea>
    <vue-mathjax :formula="formula"></vue-mathjax>
  </div>
</template>

<script>
    export default {
        props:{
            input:{default:''}
        },
        data() {
            return {
                formula: this.input,
            }
        }
    }
</script>

<style scoped>

</style>