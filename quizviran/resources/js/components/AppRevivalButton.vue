<template>
  <button class="btn btn-warning btn-sm dark-shadow" @click.prevent="revival">تمدید</button>
</template>

<script>
    import Swal from 'sweetalert2'

    export default {
        props:['exam'],
        name: "AppRevivalButton",
        methods: {
            revival() {
                this.load();
                axios.post("/quiz/exam/" + this.exam + "/revival")
                    .then(res => {
                        Swal.fire({
                            text: 'با موفقیت انجام شد.',
                            icon: 'success',
                            confirmButtonText: 'بسیار خوب',
                            timer: 2000
                        });
                    })
                    .catch(err => {
                        Swal.fire({
                            text: 'مشکلی رخ داده است.',
                            icon: 'error',
                            confirmButtonText: 'بسیار خوب',
                            timer: 2000
                        });
                    })
                .then(()=>{
                    this.closeLoad();
                });
            }
        }
    }
</script>

<style scoped>

</style>
