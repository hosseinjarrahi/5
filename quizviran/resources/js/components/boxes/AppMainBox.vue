<template>
  <div class="col-12">

    <div :class="['row flex-column mt-3 ', dark ? '' : 'text-danger' ]">
      <div class="d-flex flex-column px-4">
        <h2 class="text-center">
          <span :class="[`fas fa-${icon}`]"></span>
          <span>{{ title }}</span>
        </h2>
        <div :class="[' rounded ',dark ? 'bg-dark-gray' : 'bg-danger']" style="padding: 3px;"></div>
      </div>
    </div>

    <div class="row mt-2">
      <div class="col-12 bg-dark-gray py-3 rounded big-shadow">

        <slot></slot>

      </div>
    </div>

  </div>
</template>

<script>
    export default {
        props: {
            title: {default: ''},
            icon: {default: ''},
            dark: {default: false}
        },
        name: "AppMainBox"
    }
</script>

<style scoped>

</style>
