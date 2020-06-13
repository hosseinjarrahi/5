<template>

    <div class="loading" v-if="load">

        <div class="spinner-border my-2 text-light" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="progress w-75 w-md-50 my-2 " v-if="loadComplete">
            <div class="progress-bar" :style="`width: ${loadComplete}%;`">{{ loadComplete }}%</div>
        </div>

    </div>

</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        name: "AppLoading",
        computed:{
            ...mapGetters([
              'load',
              'loadComplete'
            ])
        }
    }
</script>

<style scoped>
.loading {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(10, 10, 10, 0.8);
    display: flex;
    justify-content: center;
    align-content: center;
    align-items: center;
    flex-direction: column;
    z-index: 99999999999999;
}
</style>
