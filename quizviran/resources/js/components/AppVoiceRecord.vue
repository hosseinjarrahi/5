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
    export default {
        name: "AppVoiceRecord",
        created() {
            navigator.mediaDevices.getUserMedia({audio: true})
                .then(stream => {
                    this.handlerFunction(stream)
                })
        },
        mounted() {
            this.player = window.EventBus.player;
        },
        data() {
            return {
                audioChunks: [],
                rec: null,
                recording: false,
                player: null,
                blob: null,
                complete:false
            }
        },
        methods: {
            clear(){
              this.complete = false;
              this.blob = null;
              this.player.src = '';
            },
            handlerFunction(stream) {
                this.rec = new MediaRecorder(stream);
                this.rec.ondataavailable = e => {
                    this.audioChunks.push(e.data);
                    if (this.rec.state == "inactive") {
                        this.blob = new Blob(this.audioChunks, {type: 'audio/mpeg-3'});
                        this.player.src = URL.createObjectURL(this.blob);
                        this.player.autoplay = true;
                    }
                }
            },
            record() {
                this.recording = true;
                this.audioChunks = [];
                this.rec.start();
            },
            stopRecord() {
                this.recording = false;
                this.rec.stop();
                this.complete = true;
            },
        }
    }
</script>

<style scoped>

</style>
