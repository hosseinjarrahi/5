<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="row justify-content-center">
          <div @click="select('question')" :class="['rounded py-1 px-3 mx-1 mb-2 hoverable border-dark-gray pointer',{ 'bg-dark-gray': selected('question') }]">
            <span class="fas fa-plus mx-1"></span><span>ایجاد سوال</span>
          </div>
          <div @click="select('category')" :class="['rounded py-1 px-3 mx-1 mb-2 hoverable border-dark-gray pointer',{ 'bg-dark-gray': selected('category') }]">
            <span class="fas fa-book mx-1"></span><span>دسته بندی ها</span>
          </div>
        </div>
      </div>
      <div class="col-12 rounded overflow-hidden bg-dark-gray p-2">
        <transition name="blur" mode="out-in">
          <div class="w-100" v-if="selected('question')" key="one-tab">
            <slot name="question"></slot>
          </div>
          <div class="w-100" v-else-if="selected('category')" key="tow-tab">
            <slot name="category"></slot>
          </div>
        </transition>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
        name: "AppQuestionManageTabs",
        data() {
            return {
                choosed: 'question'
            }
        },
        methods: {
            selected(choice) {
                return choice == this.choosed;
            },
            select(choice) {
                this.choosed = choice;
            }
        }
    }
</script>

<style scoped>
  .bg-dark-gray.hoverable{
    transform:translateY(-5px);
    box-shadow:0px 5px 2px black;
  }
</style>
