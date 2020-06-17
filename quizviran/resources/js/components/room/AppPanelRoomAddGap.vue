<template>
  <div class="bg-dark-gray big-shadow p-1 rounded">

    <div class="flex-row d-flex align-items-center">
      <transition name="slide" mode="out-in">

        <div class="flex-row d-flex align-items-center" v-if="!open" key="one" @click="open =! open">
          <span class="bg-gray d-flex flex-row align-items-center  circle p-3" style="width: 41px;height: 41px;">
            <span class="fas fa-i-cursor"></span>
          </span>
          <form action="/"></form>
          <span class="mx-2">یک گفت و گو ایجاد کنید ...</span>
        </div>


        <div class="container-fluid" v-else key="tow">
          <div class="my-3">حداکثر حجم فایل قابل ارسال 50 مگابایت می باشد.</div>
          <div class="add-gap-back rounded p-2">
            <div class="form-group">
              <textarea v-model="comment" class="form-control" cols="30" rows="10"></textarea>
            </div>

            <app-voice-record @recorded="saveInfo"></app-voice-record>

            <div class="row p-2">

              <div class="btn-group m-2" v-for="(file,index) in files" :key="index">
                <button type="button" class="left-horizon btn bg-light">{{ file.name }}</button>
                <button type="button" class="right-horizon btn btn-danger" @click="deleteFile(file.id)">&times;</button>
              </div>

            </div>

            <div class="row p-2">
            <span class="btn bg-gray btn-inset text-light mx-2 btn-file2 pointer">
              <span class="fas fa-paperclip mx-2"></span><span>پیوست فایل</span>
              <input type="file" ref="file" @change="uploadFile"/>
            </span>

              <button class="btn btn-primary btn-inset text-light mx-2" @click="save">ارسال</button>

              <button class="btn btn-inset btn-danger ml-auto text-light" @click.prevent="open = false">لغو</button>
            </div>

          </div>
        </div>
      </transition>

    </div>


  </div>
</template>

<script>
  import {mapActions, mapMutations} from 'vuex';

  export default {
    name: "AppPanelRoomAddGap",
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
      ...mapActions(['successAlert', 'errorAlert']),
      ...mapMutations(['loadOn', 'loadOff']),

      saveInfo(payload) {
        this.files.push(payload.file);
      },
      uploadFile() {
        this.file = this.$refs.file.files[0];
        let formData = new FormData();
        formData.append("file", this.file);
        axios.post("/file", formData, {
          headers: {"Content-Type": "multipart/form-data"},
          onUploadProgress: (progressEvent) => {
            this.loadOn(parseInt((progressEvent.loaded / progressEvent.total) * 100));
          },
        })
          .then((response) => {
            this.successAlert(response.data.message);
            return response.data.file;
          })
          .catch((error) => {
            this.errorAlert(error.response.data.errors.file || error.response.data.errors.max);
          })
          .then((file) => {
            this.files.push(file);
            this.loadOff();
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

        this.loadOn();
        axios.post('/quiz/panel/room/comment', {
          files: this.files,
          comment: this.comment,
          type: this.type,
          id: this.id
        })
          .then(ressponse => {
            this.successAlert();
            window.location.reload();
          })
          .catch(error => {
            this.errorAlert();
          })
          .finally(() => {
            this.loadOff()
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
  }

  .btn-file2:hover {
    background: #2a476b;
    color: #ffffff;
  }
</style>
