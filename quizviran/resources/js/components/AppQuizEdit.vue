<template>
  <form>
    <div class="form-group">
      <label>عنوان آزمون</label>
      <input v-model="edit.name" class="form-control">
    </div>
    <div class="form-group">
      <label>توضیحات آزمون</label>
      <input v-model="edit.desc" class="form-control">
    </div>
    <div class="form-group">
      <label>زمان شروع مسابقه</label>
      <date-picker locale="fa" format="YYYY/MM/DD HH:mm:ss" v-model="edit.start" type="datetime"/>
    </div>
    <div class="form-group">
      <label>مدت زمان مسابقه به دقیقه</label>
      <input class="form-control" v-model="edit.duration">
    </div>
    <button class="btn btn-primary btn-block" @click.prevent="update">ویرایش آزمون</button>
  </form>
</template>

<script>
    import Swal from 'sweetalert2';

    export default {
        name: "AppQuizMake",
        props: ['quiz'],
        data() {
            return {
                edit: this.quiz,
            }
        },
        methods: {
            update() {
                this.load();
                axios.put('/quiz/exam/' + this.edit.id, this.edit)
                    .then(res => {
                        Swal.fire({
                            text: res.data.message,
                            icon: 'success',
                            timer: 3000
                        });
                    })
                    .catch(err => {
                        Swal.fire({
                            text: 'مشکلی رخ داده',
                            icon: 'error',
                            timer: 3000
                        });
                    })
                    .then(() => {
                        this.closeLoad();
                    });

            }
        }
    }
</script>

<style scoped>

</style>