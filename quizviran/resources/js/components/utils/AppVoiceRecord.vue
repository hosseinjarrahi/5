<template>
  <div class="d-flex flex-row justify-content-between align-items-center w-100">

    <transition name="fade" mode="out-in">
      <div key="play" v-if="!recording" class="btn bg-dark-gray text-light" style="font-size:1.2rem" ref="recordBtn" @click="record">
        <span class="px-2 fas fa-microphone"></span>
      </div>

      <div key="stop" v-else class="btn bg-dark-gray text-danger" style="font-size:1.2rem" ref="stopBtn" @click="stopRecord">
        <span class="px-2 fas fa-pause-circle"></span>
      </div>
    </transition>

    <app-audio-player></app-audio-player>

    <transition name="fade" mode="out-in">
      <div v-if="complete" class="btn bg-dark-gray text-light" style="font-size:1.2rem" @click="clear">
        <span class="px-2 fas fa-times"></span>
      </div>
    </transition>

  </div>
</template>

<script>
  import Microm from 'microm';

    export default {
        name: "AppVoiceRecord",
        mounted() {
            this.player = window.EventBus.player;
        },
        data() {
            return {
                microm: new Microm(),
                recording: false,
                player: null,
                blob: null,
                complete: false,
                mp3:null
            }
        },
        methods: {

            clear() {
                this.complete = false;
                this.blob = null;
                this.player.src = '';
            },

            record() {
                this.recording = true;
                this.microm.record();
            },

            stopRecord() {
                this.microm.stop().then((result) => {
                    this.mp3 = result;
                    this.player.src = this.mp3.url;
                    this.send();
                });

                this.recording = false;
                this.complete = true;
            },

            send() {
                this.microm.getBase64().then(base64 => {
                    axios.post('/file', { base64: base64 })
                    .then(res => {
                      this.$emit('recorded',res.data);
                    })
                    .catch(err => {

                    });
                })
            },

        }
    }
</script>

<style scoped>

</style>
