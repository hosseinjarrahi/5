export default {
    methods:{
        load(complete){
            window.EventBus.$emit('loading',complete);
        },
        closeLoad(){
            window.EventBus.$emit('notLoading');
        }
    }
}