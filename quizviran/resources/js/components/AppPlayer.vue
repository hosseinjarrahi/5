<template>
  <div class="Player rounded bg-dark-gray" id="player" ref="player">
    <audio preload :src="src" class="Player__audio" ref="Player__audio">
      <p>مرورگر شما از پخش صدا پشتیبانی نمیکند.</p>
    </audio>
    <div class="Player__controlbar">
      <div class="Player__control Player__control--playing" ref="Player__control__playing">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" viewBox="0 0 16 16"
             class="Player__control--play">
          <path fill="#fff" d="M3 2l10 6-10 6z"></path>
        </svg>
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" viewBox="0 0 16 16"
             class="Player__control--paused">
          <path fill="#fff" d="M2 2h5v12h-5zM9 2h5v12h-5z"></path>
        </svg>
      </div>
    </div>
  </div>

</template>

<script>
    export default {
        name: "AppPlayer",
        props:['src'],
        data() {
            return {
                timeInterval: 0,
            }
        },
        mounted() {
            this.playerInit();
        },
        methods: {
            playerInit() {
                this.$refs.Player__control__playing.addEventListener('click', this.playerPlayControl, false);
                this.$refs.Player__audio.addEventListener('ended', this.playerEndingControl, false);
            },

            playerPlayControl() {
                this.$refs.Player__control__playing.classList.toggle('is-playing');

                if (this.$refs.Player__audio.paused) {
                    this.$refs.Player__audio.play();
                } else {
                    this.$refs.Player__audio.pause();
                }
            },

            playerEndingControl() {
                this.$refs.Player__audio.pause();
                this.$refs.Player__audio.currentTime = 0;
                this.$refs.Player__control__playing.classList.remove('is-playing');
            },

        }

    }
</script>

<style scoped>
  .Player {
    color: #fff;
    width: auto !important;
    height: 3em;
  }

  .Player__controlbar {
    display: flex;
    position: relative;
  }

  .Player__control {
    position: relative;
    text-align: center;
    width: 3em;
    height: 3em;
    line-height: 3em;
    flex: none;
  }

  .Player__control svg {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }

  .Player__control--playing{
    cursor: pointer;
  }

  .Player__control--playing .Player__control--paused,
  .Player__control--playing.is-playing .Player__control--play{
    opacity: 0;
  }

  .Player__control--playing .Player__control--play,
  .Player__control--playing.is-playing .Player__control--paused {
    opacity: 1;
  }

</style>
