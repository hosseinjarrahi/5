<template>
  <app-content-border-box title="گفت و گو های عمومی" icon="comments">

    <div class="container-fluid px-0 px-lg-1">
      <div class="mt-3 row justify-content-center align-items-center">
        <template>

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

        </template>
      </div>
    </div>

    <div class="d-flex w-100 flex-row justify-content-center">
      <app-paginator :paginator="comments" :route="route" @response="loadComments"/>
    </div>

  </app-content-border-box>
</template>

<script>
  export default {
    props: {
      'comments': {default: ''},
      'route': {default: ''},
      'userType': {default: 'student'}
    },
    data(){
      return {
        allComments: Object.assign(this.comments.data)
      }
    },
    methods: {
      loadComments(response){
        this.allComments = response.comments.data;
        //
        this.$forceUpdate();
      }
    }
  }
</script>

<style>

</style>
