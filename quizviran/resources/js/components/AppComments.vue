<template>
  <div class="container-fluid" v-if="!deleted">
    <div class="row">
      <div class="col-12">
        <div class="w-100">
          <div class="avatar-parent">
            <div
              class="avatar bg-light circle p-2 white-shadow"
              :style="{backgroundImage: `url(${avatar})`}"
            ></div>
          </div>
          <span
            class="pl-5 pr-2 py-1 bg-dark-gray rounded w-100 w-md-auto"
            style="overflow:hidden"
          >{{ comment.user.name }}</span>

          <div class="my-3 px-3 pt-3 bg-dark-gray rounded">

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

            <div class="row p-2">
              <div class="bg-gray p-2 col-12 rounded">

                <div class="d-block my-1 " v-for="(audio,index) in audios" :key="audio.id">
                  <app-player :src="'/file?hash='+audio.hash" class="w-100"></app-player>
                </div>

                <div class="btn-group mx-1 my-1" v-for="(file,index) in files" :key="file.id">
                  <a type="button" :href="`/file?hash=${file.hash}`" class="btn bg-light">
                    <span class="fas fa-download"></span>
                    {{ file.name }}
                  </a>
                  <button v-if="file.user_id == auth" type="button" class="btn btn-danger" @click="deleteFile(file.id)">&times;</button>
                </div>

              </div>
            </div>

          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
    import Swal from 'sweetalert2';
    import AppAudioPlayer from "./AppAudioPlayer";

    export default {
        components: {AppAudioPlayer},
        props: {
            comment: {
                default: function () {
                    return {'comment': ''}
                }
            },
            type: {default: null}
        },
        data() {
            return {
                deleteModal: false,
                deleted: false,
                editing: false,
                text: this.comment.comment,
                auth: window.EventBus.auth,
                avatar: this.comment.user.profile.avatar ? this.comment.user.profile.avatar : '/img/avatar.svg'
            }
        },
        methods: {
            isMp3(filename) {
                return (filename.split('.').pop() == 'mp3');
            },
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
            },
            deleteFile(id) {
                this.comment.files = this.comment.files.filter(val => {
                    return val.id != id
                });
                axios.delete('/file/' + id)
                    .then(res => console.log(res))
                    .catch(err => console.log(err));
            },
        },
        computed: {
            editable() {
                return ((this.auth == this.comment.user_id) || this.type == 'teacher');
            },
            files() {
                return this.comment.files.filter(val => {
                    return !this.isMp3(val.name);
                });
            },
            audios(){
                return this.comment.files.filter(val => {
                    return this.isMp3(val.name);
                });
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
    border: 2px solid #57606f;
    background-image: url('/img/avatar.png');
  }

  .tool-box {
    width: 100%;
    display: flex;
    justify-content: flex-end;
  }
</style>
