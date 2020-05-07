<template>
  <div class="container-fluid" v-if="!deleted">
    <div class="row">
      <div class="col-12">
        <div class="w-100">
          <div class="avatar-parent">
            <div
              class="avatar bg-light circle p-2 white-shadow"
              :style="[comment.user.profile.avatar ? {backgroundImage: `url(${comment.user.profile.avatar})`} : '']"
            ></div>
          </div>
          <span
            class="pl-5 pr-2 py-1 bg-dark-gray rounded w-100 w-md-auto"
            style="overflow:hidden"
          >{{ comment.user.name }}</span>

          <div class="my-3 p-3 bg-dark-gray rounded">

            <div class="px-2">
              <div v-if="!editing">{{ text }}</div>
              <textarea class="form-control" rows="5" v-if="editing" v-model="text"></textarea>
            </div>

            <div class="tool-box" v-if="editable && !editing">
              <span class="pointer fas fa-edit p-1 mx-1" @click="editing = !editing"></span>
              <span class="pointer text-danger fas fa-trash p-1 mx-1" @click="deleteModal = true"></span>
            </div>

            <div class="tool-box" v-if="editable && editing">
              <span class="pointer fas fa-times text-danger p-1 mx-1" @click="cancel"></span>
              <span class="pointer text-success fas fa-check-circle p-1 mx-1" @click="edit"></span>
            </div>

            <app-modal @close="deleteModal=false" title="آیا از حذف نظر خود مطمئن هستید؟" v-if="deleteModal">
              <button class="btn btn-danger" @click="deleteComment()">بله</button>
              <button class="btn btn-primary" @click="deleteModal=false">خیر</button>
            </app-modal>

            <div class="w-100 p-2 rounded my-2 bg-gray" v-if="comment.files.length > 0">
              <a class="d-block p-2" :href="`/file?hash=${file.hash}`" v-for="(file,index) in comment.files">{{ file.name }} <span class="fas fa-arrow-left"></span> <span
                class="fas fa-download"></span> <span>دانلود فایل پیوست شده</span></a>
            </div>

          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
    import Swal from 'sweetalert2';

    export default {
        props: {
            comment: {default: function(){ return {'comment' : ''}}},
            type:{default:null}
        },
        data() {
            return {
                deleteModal: false,
                deleted: false,
                editing: false,
                text: this.comment.comment,
                auth: window.EventBus.auth,
            }
        },
        methods: {
            edit() {
                this.load();
                axios.put('/quiz/panel/room/comment/' + this.comment.id, {comment: this.text})
                    .then(res => {
                        Swal.fire({
                            text: res.data.message,
                            icon: 'success',
                            timer: 5000,
                            confirmButtonText: 'بسیار خوب'
                        });
                    })
                    .catch(err => {
                        Swal.fire({
                            text: "مشکلی در ثبت اطلاعات وجود دارد.",
                            icon: 'error',
                            timer: 5000,
                            confirmButtonText: 'بسیار خوب'
                        });
                    })
                    .then(() => {
                        this.closeLoad();
                        this.editing = false;
                    });
            },
            deleteComment() {
                this.load();
                axios.delete('/quiz/panel/room/comment/' + this.comment.id)
                    .then(res => {
                        Swal.fire({
                            text: res.data.message,
                            icon: 'success',
                            timer: 5000,
                            confirmButtonText: 'بسیار خوب'
                        });
                        this.deleted = true;
                    })
                    .catch(err => {
                        Swal.fire({
                            text: err.response.data.message,
                            icon: 'error',
                            timer: 5000,
                            confirmButtonText: 'بسیار خوب'
                        });
                    }).then(() => {
                    this.closeLoad();
                    this.deleteModal = false;
                });
            },
            cancel() {
                this.editing = !this.editing;
                this.text = this.comment.comment;
            }
        },
        computed: {
            editable() {
                return ((this.auth == this.comment.user_id) || this.type == 'teacher');
            }
        }
    };
</script>

<style>
  .avatar-parent {
    position: absolute;
    top: -15px;
    left: -5px;
    width: 100%;
    display: flex;
  }

  .avatar {
    width: 50px;
    height: 50px;
    background-size: cover;
    background-position: center;
    border: 2px solid #57606f;
    background-image: url('/img/avatar.png');
  }

  .tool-box {
    width: 100%;
    display: flex;
    justify-content: flex-end;
  }
</style>
