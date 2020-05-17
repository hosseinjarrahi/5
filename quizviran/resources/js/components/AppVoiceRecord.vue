<template>
  <div class="d-flex flex-row justify-content-between align-items-center w-100">

      <transition name="fade" mode="out-in">
        <div key="play" v-if="!recording" class="btn bg-dark-gray text-light" style="font-size:1.2rem" ref="recordBtn" @click="record">
          <span class="fas fa-microphone"></span>
        </div>

        <div key="stop" v-else class="btn bg-dark-gray text-danger" style="font-size:1.2rem" ref="stopBtn" @click="stopRecord">
          <span class="fas fa-times"></span>
        </div>
      </transition>

      <app-audio-player :player="player"></app-audio-player>

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
        mounted(){
            this.player = window.EventBus.player;
        },
        data() {
            return {
                audioChunks: [],
                rec: null,
                recording: false,
                player: null
            }
        },
        methods: {
            handlerFunction(stream) {
                this.rec = new MediaRecorder(stream);
                this.rec.ondataavailable = e => {
                    this.audioChunks.push(e.data);
                    if (this.rec.state == "inactive") {
                        let blob = new Blob(this.audioChunks, {type: 'audio/mpeg-3'});
                        this.player.src = URL.createObjectURL(blob);
                        this.player.controls = true;
                        this.player.autoplay = true;
                        this.sendData(blob);
                    }
                }
            },
            sendData(data) {
                console.log(data);
            },
            record() {
                this.recording = true;
                this.audioChunks = [];
                this.rec.start();
            },
            stopRecord() {
                this.recording = false;
                this.rec.stop();
            },
        }
    }
</script>

<style scoped>

</style>
