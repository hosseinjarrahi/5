<template>
  <div class="Player" id="player" ref="player">
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
      <div class="Player__control Player__control--process">
        <input id="seek" class="Player__control Player__control--seek" ref="Player__control__seek" type="range" min="0" value="0">
      </div>
      <div class="Player__control Player__control--remaining-time" ref="Player__control__remaining_time"></div>
      <div class="Player__control Player__control--volumn" ref="Player__control__volumn">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="17" height="16" viewBox="0 0 17 16"
             class="Player__control--volumn-max">
          <path fill="#fff"
                d="M13.907 14.407c-0.192 0-0.384-0.073-0.53-0.22-0.293-0.293-0.293-0.768 0-1.061 1.369-1.369 2.123-3.19 2.123-5.127s-0.754-3.757-2.123-5.127c-0.293-0.293-0.293-0.768 0-1.061s0.768-0.293 1.061 0c1.653 1.653 2.563 3.85 2.563 6.187s-0.91 4.534-2.563 6.187c-0.146 0.146-0.338 0.22-0.53 0.22zM11.243 12.993c-0.192 0-0.384-0.073-0.53-0.22-0.293-0.293-0.293-0.768 0-1.061 2.047-2.047 2.047-5.378 0-7.425-0.293-0.293-0.293-0.768 0-1.061s0.768-0.293 1.061 0c1.275 1.275 1.977 2.97 1.977 4.773s-0.702 3.498-1.977 4.773c-0.146 0.146-0.338 0.22-0.53 0.22v0zM8.578 11.578c-0.192 0-0.384-0.073-0.53-0.22-0.293-0.293-0.293-0.768 0-1.061 1.267-1.267 1.267-3.329 0-4.596-0.293-0.293-0.293-0.768 0-1.061s0.768-0.293 1.061 0c1.852 1.852 1.852 4.865 0 6.718-0.146 0.146-0.338 0.22-0.53 0.22z"></path>
          <path fill="#fff"
                d="M6.5 15c-0.13 0-0.258-0.051-0.354-0.146l-3.854-3.854h-1.793c-0.276 0-0.5-0.224-0.5-0.5v-5c0-0.276 0.224-0.5 0.5-0.5h1.793l3.854-3.854c0.143-0.143 0.358-0.186 0.545-0.108s0.309 0.26 0.309 0.462v13c0 0.202-0.122 0.385-0.309 0.462-0.062 0.026-0.127 0.038-0.191 0.038z"></path>
        </svg>
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" viewBox="0 0 16 16"
             class="Player__control--volumn-min">
          <path fill="#fff"
                d="M15 9.674v1.326h-1.326l-1.674-1.674-1.674 1.674h-1.326v-1.326l1.674-1.674-1.674-1.674v-1.326h1.326l1.674 1.674 1.674-1.674h1.326v1.326l-1.674 1.674 1.674 1.674z"></path>
          <path fill="#fff"
                d="M6.5 15c-0.13 0-0.258-0.051-0.354-0.146l-3.854-3.854h-1.793c-0.276 0-0.5-0.224-0.5-0.5v-5c0-0.276 0.224-0.5 0.5-0.5h1.793l3.854-3.854c0.143-0.143 0.358-0.186 0.545-0.108s0.309 0.26 0.309 0.462v13c0 0.202-0.122 0.385-0.309 0.462-0.062 0.026-0.127 0.038-0.191 0.038z"></path>
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
                this.$refs.Player__control__volumn.addEventListener('click', this.playerVolumnControl, false);
                this.$refs.Player__control__seek.addEventListener('change', this.playerChangeSeekControl, false);
                this.$refs.Player__audio.addEventListener('ended', this.playerEndingControl, false);
                this.$refs.Player__audio.addEventListener('loadedmetadata', this.playerLoadMetadata, false);
            },

            playerPlayControl() {
                this.$refs.Player__control__playing.classList.toggle('is-playing');

                if (this.$refs.Player__audio.paused) {
                    this.$refs.Player__audio.play();
                    this.timeInterval = setInterval(this.playerTimeUpdate, 100);
                    this.$refs.Player__control__seek.addEventListener('change', this.playerSeekControl, false);
                } else {
                    this.$refs.Player__audio.pause();
                    clearInterval(this.timeInterval);
                }
            },

            playerSeekControl() {
                this.$refs.Player__audio.currentTime = this.$refs.Player__control__seek.value;
            },

            playerVolumnControl() {
                this.$refs.Player__control__volumn.classList.toggle('is-muted');

                if (this.$refs.Player__audio.muted) {
                    this.$refs.Player__audio.muted = false;
                } else {
                    this.$refs.Player__audio.muted = true;
                }
            },

            playerTimeUpdate() {
                this.$refs.Player__control__remaining_time.innerHTML = this.s2m(this.$refs.Player__audio.duration - this.$refs.Player__audio.currentTime);
                this.$refs.Player__control__seek.max = this.$refs.Player__audio.duration;
                this.$refs.Player__control__seek.value = this.$refs.Player__audio.currentTime;
            },

            playerLoadMetadata() {
                this.$refs.Player__control__remaining_time.innerHTML = this.s2m(this.$refs.Player__audio.duration);
            },

            playerChangeSeekControl() {
                this.$refs.Player__control__seek.max = this.$refs.Player__audio.duration;
                this.$refs.Player__audio.currentTime = this.$refs.Player__control__seek.value;
            },

            playerEndingControl() {
                this.$refs.Player__audio.pause();
                this.$refs.Player__audio.currentTime = 0;
                this.$refs.Player__control__playing.classList.remove('is-playing');
            },

            s2m(seconds) {
                let m = Math.floor((((seconds % 31536000) % 86400) % 3600) / 60);
                let s = (((seconds % 3153600) % 86400) % 3600) % 60;

                m = m >= 10 ? m : ('0' + m);

                if (s >= 10) {
                    return m + ':' + Math.round(s);
                } else {
                    return m + ':0' + Math.round(s);
                }
            }

        }

    }
</script>

<style scoped>
  .Player {
    background: #47a3da;
    border: 1px solid #47a3da;
    color: #fff;
    width: 30em;
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

  .Player__control--playing,
  .Player__control--volumn {
    cursor: pointer;
  }

  .Player__control--playing .Player__control--paused,
  .Player__control--playing.is-playing .Player__control--play,
  .Player__control--volumn .Player__control--volumn-min,
  .Player__control--volumn.is-muted .Player__control--volumn-max {
    opacity: 0;
  }

  .Player__control--playing .Player__control--play,
  .Player__control--playing.is-playing .Player__control--paused,
  .Player__control--volumn .Player__control--volumn-max,
  .Player__control--volumn.is-muted .Player__control--volumn-min {
    opacity: 1;
  }

  .Player__control--process {
    flex: auto;
    padding: 0 1em;
  }

  .Player__control--seek {
    appearance: none;
    height: 2px;
    width: 100%;
    vertical-align: middle;
    display: inline-block;
    box-shadow: 0 1px 10px 0 rgba(255, 255, 255, .8);
  }

  .Player__control--seek::-webkit-slider-thumb {
    appearance: none;
    background: #fff;
    width: 1em;
    height: 1em;
    border-radius: 100%;
    border: 1px solid transparent;
    box-shadow: 0 1px 10px 0 rgba(255, 255, 255, .8);
    z-index: 1;
  }

  .Player__control--remaining-time {
    width: 4em;
  }
</style>
