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
          <div class="my-3 p-3 bg-dark-gray rounded">

            <p class="px-2">
            <div v-if="!editing">{{ comment.comment}}</div>
            <textarea class="form-control" rows="5" v-if="editing" v-model="text"></textarea>
            </p>

            <div class="tool-box" v-if="auth == comment.user_id && !editing">
              <span class="pointer fas fa-edit p-1 mx-1" @click="editing = !editing"></span>
              <span class="pointer text-danger fas fa-trash p-1 mx-1" @click="deleteModal = true"></span>
            </div>

            <div class="tool-box" v-if="auth == comment.user_id && editing">
              <span class="pointer fas fa-times text-danger p-1 mx-1" @click="editing = !editing"></span>
              <span class="pointer text-success fas fa-check-circle p-1 mx-1" @click="edit"></span>
            </div>

            <app-modal @close="deleteModal=false" title="آیا از حذف نظر خود مطمئن هستید؟" v-if="deleteModal">
              <button class="btn btn-danger" @click="deleteComment()">بله</button>
              <button class="btn btn-primary" @click="deleteModal=false">خیر</button>
            </app-modal>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import {mapActions, mapMutations} from "vuex";

  export default {
    props: ['comment'],
    data() {
      return {
        deleteModal: false,
        deleted: false,
        editing: false,
        text: this.comment.comment,
        auth: window.EventBus.auth
      }
    },
    methods: {
      ...mapActions(['loadOff', 'loadOn']),
      ...mapMutations(['errorAlert', 'successAlert']),

      edit() {
        this.loadOn();
        axios.put('/comment/' + this.comment.id, {comment: this.text})
          .then(response => {
            this.successAlert(res.data.message);
          })
          .catch(error => {
            this.errorAlert('مشکلی در ثبت اطلاعات وجود دارد');
          })
          .then(() => {
            this.loadOff();
            this.editing = false;
          });
      },
      deleteComment() {
        this.loadOn();
        axios.delete('/comment/' + this.comment.id)
          .then(response => {
            this.successAlert(res.data.message);
            this.deleted = true;
          })
          .catch(error => {
            this.errorAlert(err.response.data.message);
          })
          .then(() => {
            this.loadOff();
            this.deleteModal = false;
          });
      },
    },
    computed: {
      avatar() {
        if (this.comment.user.profile.avatar)
          return this.comment.user.profile.avatar;
        return '/img/avatar.svg';
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
  }

  .tool-box {
    width: 100%;
    display: flex;
    justify-content: flex-end;
  }
</style>
