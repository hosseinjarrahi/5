<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="w-100">
          <div class="avatar-parent">
            <div class="avatar bg-light circle p-2 white-shadow"
                 :style="{backgroundImage: `url(${comment.user.profile.avatar})`}">
            </div>
          </div>

          <span class="pl-5 pr-2 py-1 bg-dark-gray rounded w-100 w-md-auto"
            style="overflow:hidden" v-text="comment.user.name">
          </span>

          <div class="my-3 px-3 pt-3 bg-dark-gray overflow-hidden rounded">

            <div class="px-2" style="white-space: pre-wrap">
              <div v-if="!editing" v-html.trim="comment.comment"></div>
              <textarea class="form-control" rows="5" v-if="editing" v-model="comment.comment"></textarea>
            </div>

            <div class="tool-box my-2" v-if="editable && !editing">
              <span class="pointer fas fa-edit p-1 mx-1" @click="editing = !editing"></span>
              <span class="pointer text-danger fas fa-trash p-1 mx-1" @click="toggleDeleteModal(comment)"></span>
            </div>

            <div class="tool-box my-2" v-if="editable && editing">
              <span class="pointer fas fa-times text-danger p-1 mx-1" @click="cancel"></span>
              <span class="pointer text-success fas fa-check-circle p-1 mx-1" @click="updateGap(comment)"></span>
            </div>

            <div class="row justify-content-center">

              <div class="bg-gray mt-2 p-0 text-center col-12 rounded">

                <div class="d-flex flex-row my-1 align-items-center">
                  <template v-for="audio in audios">
                    <app-player :src="'/file?hash='+audio.hash" class="mx-1"></app-player>
                  </template>

                  <div class="btn-group mx-1" v-for="(file,index) in files" :key="file.id">
                    <a type="button" :href="`/file?hash=${file.hash}`" :class="['btn bg-light',{'left-horizon':file.user_id == auth}]">
                      <span class="fas fa-download"></span>
                      {{ file.name }}
                    </a>
                    <button v-if="file.user_id == auth" type="button" class="right-horizon btn btn-danger" @click="deleteCommentFile(file.id)">&times;</button>
                  </div>

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
  import {mapActions, mapMutations} from 'vuex';

  export default {

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
        editing: false,
        auth: window.EventBus.auth
      }
    },

    methods: {
      ...mapActions([
        'updateComment',
        'deleteCommentFile',
      ]),

      ...mapMutations([
        'toggleDeleteModal'
      ]),

      updateGap(comment) {
        this.editing = false;
        this.updateComment(comment);
      },

      cancel() {
        this.editing = !this.editing;
      },

      isMp3(filename) {
        return (filename.split('.').pop() == 'mp3');
      },
    },

    computed: {

      files() {
        return this.comment.files.filter(val => {
          return !this.isMp3(val.name);
        });
      },

      audios() {
        return this.comment.files.filter(val => {
          return this.isMp3(val.name);
        });
      },

      editable() {
        return ((this.auth == this.comment.user_id) || this.type == 'teacher');
      },

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
  }

  .tool-box {
    width: 100%;
    display: flex;
    justify-content: flex-end;
  }
</style>
