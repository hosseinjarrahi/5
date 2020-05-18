<template>
  <div class="bg-dark-gray p-1 rounded mb-5">

    <div class="flex-row d-flex align-items-center">
      <transition name="slide" mode="out-in">

        <div class="flex-row d-flex align-items-center" v-if="!open" key="one" @click="open =! open">
          <span class="bg-gray d-flex flex-row align-items-center  circle p-3" style="width: 41px;height: 41px;">
            <span class="fas fa-i-cursor"></span>
          </span>
          <form action="/"></form>
          <span class="mx-2">یک گفت و گو ایجاد کنید ...</span>
        </div>


        <div class="container" v-else key="tow">
          <div class="my-3">حداکثر حجم فایل قابل ارسال 50 مگابایت می باشد.</div>
          <div class="add-gap-back rounded p-2">
            <div class="form-group">
              <textarea v-model="comment" class="form-control" cols="30" rows="10"></textarea>
            </div>

            <app-voice-record @recorded="saveInfo"></app-voice-record>

            <div class="row p-2">

              <div class="btn-group m-2" v-for="(file,index) in files" :key="index">
                <button type="button" class="btn bg-light">{{ file.name }}</button>
                <button type="button" class="btn btn-danger" @click="deleteFile(file.id)">&times;</button>
              </div>

            </div>

            <div class="row p-2">
            <span class="btn bg-gray text-light mx-2 btn-file2 pointer">
              <span class="fas fa-paperclip mx-2"></span><span>پیوست فایل</span>
              <input type="file" ref="file" @change="uploadFile"/>
            </span>

              <button class="btn bg-gray text-light mx-2" @click="save">ارسال</button>

              <button class="btn btn-danger ml-auto text-light" @click.prevent="open = false">لغو</button>
            </div>

          </div>
        </div>
      </transition>

    </div>


  </div>
</template>

<script>
    import Swal from 'sweetalert2';
    import AppVoiceRecord from "./AppVoiceRecord";

    export default {
        name: "AppPanelRoomAddGap",
        components: {AppVoiceRecord},
        props: ['type', 'id'],
        data() {
            return {
                open: false,
                files: [],
                complete: 0,
                comment: ''
            }
        },
        methods: {
            saveInfo(payload){
                this.files.push(payload.file);
            },
            uploadFile() {
                this.file = this.$refs.file.files[0];
                let load = this.load;
                let formData = new FormData();
                formData.append("file", this.file);
                axios.post("/file", formData, {
                    headers: {"Content-Type": "multipart/form-data"},
                    onUploadProgress: function (progressEvent) {
                        load(parseInt((progressEvent.loaded / progressEvent.total) * 100));
                    },
                })
                    .then(function (response) {
                        Swal.fire({
                            text: response.data.message,
                            icon: 'success',
                            confirmButtonText: 'بسیار خوب',
                            timer: 5000
                        });
                        return response.data.file;
                    })
                    .catch(function (error) {
                        Swal.fire({
                            text: error.response.data.errors.file || error.response.data.errors.max,
                            icon: 'error',
                            confirmButtonText: 'بسیار خوب',
                            timer: 5000
                        });
                    })
                    .then((file) => {
                        this.files.push(file);
                        this.closeLoad();
                    });
            },
            deleteFile(id) {
                this.files = this.files.filter(val => {
                    return val.id != id
                });
                axios.delete('/file/' + id)
                    .then(res => console.log(res))
                    .catch(err => console.log(err));
            },
            save() {
                if (this.comment == '')
                    return;
                axios.post('/quiz/panel/room/comment', {
                    files: this.files,
                    comment: this.comment,
                    type: this.type,
                    id: this.id
                })
                    .then(res => {
                        Swal.fire({
                            text: 'با موفقیت ارسال شد.',
                            icon: 'success',
                            confirmButtonText: 'بسیار خوب',
                            timer: 5000
                        });
                        window.location.reload();
                    })
                    .catch(err => {
                        Swal.fire({
                            text: 'مشکلی در ارسال به وجود آمده است.',
                            icon: 'error',
                            confirmButtonText: 'بسیار خوب',
                            timer: 5000
                        });
                    });
            },

        }
    }
</script>

<style scoped>
  .add-gap-back {
    width: 100%;
    height: 100%;
  }

  .drop-enter-active, .drop-leave-active {
    transition: all .5s;
  }

  .drop-enter, .drop-leave-to {
    transform: scale(0);
  }

  .btn-file2 input[type="file"] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    opacity: 0;
    outline: none;
    cursor: pointer;
    display: block;
  }

  .btn-file2 {
    position: relative;
    overflow: hidden;
    font-weight: bold;
    border: 2px solid #2a476b;
  }

  .btn-file2:hover {
    background: #2a476b;
    color: #ffffff;
  }
</style>
