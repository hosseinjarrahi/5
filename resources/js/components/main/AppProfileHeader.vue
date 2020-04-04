import Swal from "sweetalert2";
<template>
  <div class="w-100 col-12 profile-header" style="margin-top:40px;">
    <div class="row justify-content-center position-relative">

      <div class="avatar-parent2">
        <div class="avatar2 bg-light circle p-2"
             :style="{backgroundImage: `url(${avatar})`}"></div>

        <span class="btn btn-outline-dark btn-file pointer mb-5" style="z-index: 2">
            تعویض عکس پروفایل
            <input type="file" ref="file" @change="uploadAvatar"/>
        </span>

      </div>

    </div>
  </div>
</template>

<script>
    import Swal from 'sweetalert2';

    export default {
        name: "AppProfileHeader",
        props: ['user'],
        data() {
            return {
                avatar: this.user.profile.avatar
            }
        },
        methods: {
            uploadAvatar() {
                this.load();
                this.file = this.$refs.file.files[0];

                let formData = new FormData();
                formData.append("file", this.file);

                axios.post("/upload-avatar", formData, {
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
                        return response.data.avatar;
                    })
                    .catch(function (error) {
                        Swal.fire({
                            text: error.response.data.errors.file || error.response.data.errors.max,
                            icon: 'error',
                            confirmButtonText: 'بسیار خوب',
                            timer: 5000
                        });
                    })
                    .then(avatar => {
                        this.avatar = avatar ? avatar : this.avatar;
                        this.closeLoad();
                    });
            }
        }
    }
</script>

<style scoped>
  .profile-header {
    height: 220px;
    background: #2f3542;
    background-image: -moz-radial-gradient(50% 50%, circle closest-side, rgb(121, 127, 142) 0%, rgb(121, 127, 142) 0%, rgb(84, 90, 104) 59%, rgb(47, 53, 66) 100%);
    background-image: -webkit-radial-gradient(50% 50%, circle closest-side, rgb(121, 127, 142) 0%, rgb(121, 127, 142) 0%, rgb(84, 90, 104) 59%, rgb(47, 53, 66) 100%);
    background-image: -ms-radial-gradient(50% 50%, circle closest-side, rgb(121, 127, 142) 0%, rgb(121, 127, 142) 0%, rgb(84, 90, 104) 59%, rgb(47, 53, 66) 100%);
  }

  .avatar-parent2 {
    top: 130px;
    position: absolute;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }

  .avatar2 {
    width: 150px;
    height: 150px;
    background-size: cover;
    background-position: center;
    border: 5px solid #2f3542;
    box-shadow: 0px 5px 5px #2f3542;
  }
</style>