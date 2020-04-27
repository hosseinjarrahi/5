<template>
  <div>
    <textarea v-model="formula" name="desc" class="mb-5 form-control" cols="30" rows="10"></textarea>
    <app-content-border-box class="mx-auto" style="width: 90%" title="پیش نمایش سوال">
      <vue-mathjax style="white-space: pre" :formula="formula"></vue-mathjax>
    </app-content-border-box>
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