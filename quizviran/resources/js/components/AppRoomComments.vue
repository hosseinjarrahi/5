<template>
  <app-content-border-box title="گفت و گو های عمومی" icon="comments">

    <div class="container-fluid px-0 px-lg-1">
      <transition-group name="scale" mode="in-out" class="mt-3 row justify-content-center align-items-center">
        <app-comment class="mt-2"
                     v-for="(comment,index) in allComments"
                     :key="'comment'+index"
                     :comment="comment"
                     :type="userType">
        </app-comment>
      <div v-if="!this.comments.total" class="d-flex flex-column justify-content-center align-items-center">
        <span class="fas fa-comment-slash fa-4x my-2"></span>
        <span>گفت و گویی وجود ندارد ...</span>
      </div>
      </transition-group>

    </div>

    <div class="d-flex w-100 flex-row justify-content-center">
      <app-paginator :paginator="comments" :route="route" @response="loadComments"/>
    </div>

  </app-content-border-box>
</template>

<script>
  import {mapGetters, mapMutations} from 'vuex';

  export default {
    props: {
      'comments': {default: ''},
      'route': {default: ''},
      'userType': {default: 'student'}
    },
    created() {
      this.setComments(Object.assign(this.comments.data));
    },
    methods: {
      ...mapMutations(['setComments']),
      loadComments(response) {
        this.setComments(response.comments.data);
      }
    },
    computed: {
      ...mapGetters({allComments: 'roomComments'})
    }
  }
</script>

<style>

</style>
