<template>

    <div class="loading" v-if="loading">

        <div class="spinner-border my-2 text-light" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="progress w-75 w-md-50 my-2 " v-if="complete">
            <div class="progress-bar" :style="`width: ${complete}%;`">{{ complete }}%</div>
        </div>

    </div>

</template>

<script>
    export default {
        name: "AppLoading",
        props:{
          complete:{default:null}
        },
        data(){
            return{
                loading:false
            }
        },
        created() {
            window.EventBus.$on('loading',(complete)=>{
                this.loading = true;
                this.complete = complete;
            });
            window.EventBus.$on('notLoading',()=>{
                this.loading = false;
                this.complete = false;
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
    flex-direction: column;
    z-index: 99999999999999;
}
</style>