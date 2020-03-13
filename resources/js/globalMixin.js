export default {
    methods:{
        load(){
            window.EventBus.$emit('loading');
        },
        closeLoad(){
            window.EventBus.$emit('notLoading');
        }
    }
}