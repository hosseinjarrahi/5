<template>
  <v-overlay :value="load">
    <v-progress-circular indeterminate size="64"></v-progress-circular>
  </v-overlay>
</template>

<script>
export default {
  computed:{
    load(){
      return this.$store.state.load;
    }
  }
}
</script>

<style>

</style>