<template>
  <div class="w-100 mt-5">
    <textarea class="form-control bg-gray" v-model="comment" rows="10"></textarea>
    <span class="btn bg-dark-gray my-2" @click="send">افزودن نظر</span>
  </div>
</template>

<script scoped>
    import Swal from "sweetalert2";

    export default {
        props: ['type', 'id'],
        data() {
            return {
                comment: ''
            };
        },
        methods: {
            send() {
                if (this.comment == '')
                    return;
                this.load();
                axios
                    .post('/comment', {
                        comment: this.comment,
                        type: this.type,
                        id: this.id
                    })
                    .then(res => {
                        Swal.fire({
                            text: 'پس از تایید ، نظر شما نمایش داده خواهد شد',
                            icon: 'success',
                            timer: 5000,
                            confirmButtonText: "بسیار خوب",
                        });
                    })
                    .catch(err => {
                        Swal.fire({
                            text: 'مشکلی در ثبت نظر شما به وجو آمده است.',
                            icon: 'success',
                            timer: 5000,
                            confirmButtonText: "بسیار خوب",
                        });
                    })
                    .then(() => {
                        this.closeLoad();
                    });
            }
        }
    };
</script>
