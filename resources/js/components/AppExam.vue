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
        <div class="col-11 col-md-6 p-3 bg-light shadow rounded my-2">

          <span class="btn block-btn btn-block btn-file mb-5">
            ارسال فایل
            <input type="file" ref="file" @change="uploadFile"/>
          </span>

          <button class="btn btn-block btn-primary" @click="complete()">اتمام</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    import Swal from 'sweetalert2';

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
            complete() {
                this.load();
                let id = this.id;
                axios.post("/complete", {data: this.selected, id: this.id})
                    .then(function (response) {
                        Swal.fire({
                            // title: 'Error!',
                            text: response.data.message,
                            icon: response.data.type,
                            confirmButtonText: 'بسیار خوب',
                            timer: 5000
                        });
                        setTimeout(() => {
                            window.location = `/results/${id}`;
                        }, 3000);
                    })
                    .catch(function (error) {
                        console.log(error.message);
                        Swal.fire({
                            // title: 'Error!',
                            text: error.message,
                            icon: error.type,
                            confirmButtonText: 'بسیار خوب',

                            timer: 5000
                        });
                    })
                    .then(() => {
                        this.closeLoad();
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
                        Swal.fire({
                            text: response.data.message,
                            icon: 'success',
                            confirmButtonText: 'بسیار خوب',
                            timer: 5000
                        });
                    })
                    .catch(function (error) {
                        Swal.fire({
                            text: error.response.data.errors.file || error.response.data.errors.max,
                            icon: 'error',
                            confirmButtonText: 'بسیار خوب',
                            timer: 5000
                        });
                    });
                this.closeLoad();
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