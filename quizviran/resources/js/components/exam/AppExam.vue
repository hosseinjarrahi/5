<template>
  <div class="col-12">
    <app-exam-card
      v-for="(q,index) in quests"
      :key="index"
      :desc="q.desc"
      :img="q.pic"
      :A="q.A"
      :B="q.B"
      :C="q.C"
      :D="q.D"
      :type="q.type"
      :number="index"
      :id="q.id"
      @change="handleSelecting"
    ></app-exam-card>

    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-11 col-md-4 p-3 rounded my-2">

          <!--          <span class="btn block-btn btn-block btn-file mb-5">-->
          <!--            ارسال فایل-->
          <!--            <input type="file" ref="file" @change="uploadFile"/>-->
          <!--          </span>-->

          <button class="btn btn-block shadow btn-primary" @click="complete()">
            <span class="fas fa-clipboard-check"></span>
            <span>اتمام</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import {mapActions, mapMutations} from 'vuex';

  export default {
    data() {
      return {
        selected: [],
      };
    },
    props: {
      id: {default: ""},
      questions: {default: ""}
    },
    computed: {
      quests() {
        return JSON.parse(this.questions);
      }
    },
    methods: {
      ...mapMutations(['loadOff', 'loadOn']),
      ...mapActions(['sweetAlert', 'redirect']),
      complete() {
        this.loadOff();
        let id = this.id;
        axios.post("/quiz/complete", {data: this.selected, id: this.id})
          .then(function (response) {

            this.sweetAlert({
              text: response.data.message,
              icon: response.data.type,
            });

            this.redirect({
              url: `/quiz/results/${id}`,
              timer: 2000
            });

          })
          .catch(function (error) {
            this.sweetAlert({
              text: error.message,
              icon: error.type,
            });
          })
          .then(() => {
            this.loadOff();
          });
      },
      handleSelecting() {
        this.selected.forEach((val, index) => {
          if (val.id == arguments[0].id) this.selected.splice(index, 1);
        });
        this.selected.push(arguments[0]);
      },
      uploadFile() {
        this.load();
        this.file = this.$refs.file.files[0];

        let formData = new FormData();
        formData.append("file", this.file);
        formData.append("id", this.id);

        axios.post("/file", formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
          .then(function (response) {
            this.sweetAlert({
              text: response.data.message,
              icon: 'success',
            });
          })
          .catch(function (error) {
            this.sweetAlert({
              text: error.response.data.errors.file || error.response.data.errors.max,
              icon: 'error',
            });
          })
          .finally(() => {
            this.loadOff();
          });
      }
    }
  };
</script>

<style>
  .btn-file input[type="file"] {
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

  .btn-file {
    position: relative;
    overflow: hidden;
    color: #2a476b;
    font-weight: bold;
    background-color: #f1f1ef;
    box-shadow: 1px 10px 20px 0px rgba(218, 215, 206, 0.8);
    border: 2px solid #2a476b;
  }

  .btn-file:hover {
    background: #2a476b;
    color: #ffffff;
  }

  @media only screen and (max-width: 980px) {
    .block-btn {
      text-align: center;
      position: relative;
      margin: 10px 0px;
      display: block;
    }
  }

</style>
