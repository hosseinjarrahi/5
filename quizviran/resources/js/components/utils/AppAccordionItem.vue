<template>
  <div class="w-100">
    <div class="w-100 rounded p-2 bg-darkest" @click.self="open = !open">
      <p class="pointer text-center my-0" @click="open = !open">
        <span>{{ title }}</span>
        <span :class="['fas float-right px-2 py-1','fa-arrow-alt-circle-' + arrow]"></span>
      </p>
      <transition name="slide" mode="out-in">
        <div class="mt-2 w-100 rounded p-2 " v-if="open">
          <slot></slot>
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
    export default {
        name: "AppAccordionItem",
        props: {
            title: {default: ''}
        },
        data() {
            return {
                open: false
            }
        },
        computed:{
            arrow(){
                return this.open ? 'down' : 'left';
            }
        }
    }
</script>

<style scoped>

</style>
