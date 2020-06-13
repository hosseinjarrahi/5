<template>
  <div class="w-100 mt-5">
    <textarea class="form-control rounded bg-gray" v-model="comment" rows="10"></textarea>
    <span class="btn bg-dark-gray rounded my-2" @click="send">افزودن نظر</span>
  </div>
</template>

<script scoped>
  import {mapActions, mapMutations} from 'vuex';

  export default {
    props: ['type', 'id'],
    data() {
      return {
        comment: ''
      };
    },
    methods: {
      ...mapActions(['loadOff', 'loadOn']),
      ...mapMutations(['errorAlert', 'successAlert']),
      send() {
        if (this.comment == '') return;

        this.loadOn();

        axios.post('/comment', {
          comment: this.comment,
          type: this.type,
          id: this.id
        })
          .then(res => {
            this.successAlert('پس از تایید ، نظر شما نمایش داده خواهد شد');
          })
          .catch(err => {
            this.errorAlert('مشکلی در ثبت نظر شما به وجو آمده است');
          })
          .then(() => {
            this.loadOff();
          });
      }
    }
  };
</script>
