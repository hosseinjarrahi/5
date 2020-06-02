<template>
  <span>
  <button class="btn btn-warning btn-sm dark-shadow" @click.prevent="revival">تمدید</button>
  <button class="btn btn-secondary btn-sm dark-shadow" @click.prevent="revival('sub')">کاهش</button>
  </span>
</template>

<script>
    import Swal from 'sweetalert2'

    export default {
        props:['exam'],
        name: "AppRevivalButton",
        methods: {
            revival(sub = '') {
                this.load();
                axios.post("/quiz/exam/" + this.exam + "/revival",{ sub: sub })
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
