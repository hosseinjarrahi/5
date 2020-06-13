<template>
  <span>
  <button class="btn btn-warning btn-sm dark-shadow" @click.prevent="revival">تمدید</button>
  <button class="btn btn-secondary btn-sm dark-shadow" @click.prevent="revival('sub')">کاهش</button>
  </span>
</template>

<script>

  import {mapActions, mapMutations} from "vuex";

  export default {
    props: ['exam'],
    name: "AppRevivalButton",
    methods: {
      ...mapActions(['successAlert', 'errorAlert']),
      ...mapMutations(['loadOn', 'loadOff']),

      revival(sub = '') {
        this.loadOn();
        axios.post("/quiz/exam/" + this.exam + "/revival", {sub: sub})
          .then(res => {
            this.successAlert();
          })
          .catch(err => {
            this.errorAlert();
          })
          .then(() => {
            this.loadOff();
          });
      }
    }
  }
</script>
