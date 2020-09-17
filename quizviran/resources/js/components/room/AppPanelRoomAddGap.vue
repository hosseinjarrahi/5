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
          <div class="my-3">پیام شما پس از تایید ناظر برای عموم قابل مشاهده خواهد بود.</div>
          <div class="my-3">حداکثر حجم فایل قابل ارسال 50 مگابایت می باشد.</div>
          <div class="add-gap-back rounded p-2">
            <div class="form-group">
              <textarea autofocus v-model.trim="comment" class="form-control" cols="30" rows="5"></textarea>
            </div>

            <app-voice-record @recorded="pushToFiles($event.file)"></app-voice-record>

            <div class="row p-2">

              <div class="btn-group m-2" v-for="(file,index) in files" :key="index">
                <button type="button" class="left-horizon btn bg-light">{{ file.name }}</button>
                <button type="button" class="right-horizon btn btn-danger" @click="deleteGapFile(file.id)">&times;</button>
              </div>

            </div>

            <div class="row p-2">
            <span class="btn bg-gray btn-inset text-light mx-2 btn-file2 pointer">
              <span class="fas fa-paperclip mx-2"></span><span>پیوست فایل</span>
              <input type="file" ref="file" @change="uploadGapFile($refs.file.files[0])"/>
            </span>

              <button class="btn btn-primary btn-inset text-light mx-2" @click="createRoomComment(fields)">ارسال</button>

              <button class="btn btn-inset btn-danger ml-auto text-light" @click.prevent="open = false">لغو</button>
            </div>

          </div>
        </div>

      </transition>
    </div>

  </div>
</template>

<script>
  import {mapActions, mapMutations, mapGetters} from 'vuex';

  export default {
    name: "AppPanelRoomAddGap",
    props: ['type', 'id'],
    data() {
      return {
        open: false,
        complete: 0,
        comment: ''
      }
    },
    methods: {
      ...mapActions(['createRoomComment', 'uploadGapFile', 'deleteGapFile']),
      ...mapMutations(['pushToFiles']),
    },
    computed: {
      ...mapGetters(['files']),
      fields() {
        return {
          files: this.files,
          comment: this.comment,
          type: this.type,
          id: this.id
        };
      }
    }
  }
</script>

<style scoped>
  .add-gap-back {
    width: 100%;
    height: 100%;
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
