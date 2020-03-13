<template>

    <div class="loading" v-if="loading">
        <div class="spinner-border text-light" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

</template>

<script>
    export default {
        name: "AppLoading",
        data(){
            return{
                loading:false
            }
        },
        created() {
            window.EventBus.$on('loading',()=>{
                this.loading = true;
            });
            window.EventBus.$on('notLoading',()=>{
                this.loading = false;
            });
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
    z-index: 500;
}
</style>