<template>
  <div class="holder">
    <div class="audio green-audio-player" ref="audioPlayer">
      <div class="play-pause-btn d-block" ref="playpauseBtn">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="24" viewBox="0 0 18 24">
          <path fill="white" fill-rule="evenodd" d="M18 12L0 24V0" class="play-pause-icon" ref="playPause"/>
        </svg>
      </div>

      <div class="controls">
        <span class="current-time" ref="currentTime">0:00</span>
        <div class="slider" data-direction="horizontal">
          <div class="progress" ref="progress">
            <div class="pin" ref="draggableClasses" id="progress-pin" data-method="rewind"></div>
          </div>
        </div>
<!--        <span class="total-time" ref="totalTime">0:00</span>-->
      </div>

      <audio crossorigin ref="player"></audio>
    </div>

  </div>
</template>

<script>
    export default {
        name: "AppAudioPlayer",
        mounted() {
            window.EventBus.player = this.$refs.player;

            this.$refs.playpauseBtn.addEventListener('click', this.togglePlay);
            this.$refs.player.addEventListener('timeupdate', this.updateProgress);
            this.$refs.player.addEventListener('loadedmetadata', () => {
                // this.$refs.totalTime.textContent = this.formatTime(this.$refs.player.duration);
            });
            this.$refs.player.addEventListener('canplay', this.makePlay);
            this.$refs.player.onended = () => {
                this.$refs.playPause.attributes.d.value = "M18 12L0 24V0";
                this.$refs.player.currentTime = 0;
            };

        },
        data() {
            return {
                currentlyDragged: null,
                sliders: []
            }
        },
        methods: {
            inRange(event) {
                let rangeBox = this.getRangeBox(event);
                let rect = rangeBox.getBoundingClientRect();
                let direction = rangeBox.dataset.direction;
                if (direction == 'horizontal') {
                    let min = rangeBox.offsetLeft;
                    let max = min + rangeBox.offsetWidth;
                    if (event.clientX < min || event.clientX > max) return false;
                } else {
                    let min = rect.top;
                    let max = min + rangeBox.offsetHeight;
                    if (event.clientY < min || event.clientY > max) return false;
                }
                return true;
            },
            updateProgress() {
                let current = this.$refs.player.currentTime;
                let percent = (current / this.$refs.player.duration) * 100;
                this.$refs.progress.style.width = percent + '%';

                this.$refs.currentTime.textContent = this.formatTime(current);
            },
            getRangeBox(event) {
                let rangeBox = event.target;
                let el = this.currentlyDragged;
                if (event.type == 'click' && this.isDraggable(event.target)) {
                    rangeBox = event.target.parentElement.parentElement;
                }
                if (event.type == 'mousemove') {
                    rangeBox = el.parentElement.parentElement;
                }
                return rangeBox;
            },
            rewind(event) {
                if (this.inRange(event)) {
                    this.$refs.player.currentTime = this.$refs.player.duration;
                }
            },
            formatTime(time) {
                let min = Math.floor(time / 60);
                let sec = Math.floor(time % 60);
                return min + ':' + ((sec < 10) ? ('0' + sec) : sec);
            },
            togglePlay() {
                if (this.$refs.player.paused) {
                    this.$refs.playPause.attributes.d.value = "M0 0h6v24H0zM12 0h6v24h-6z";
                    this.$refs.player.play();
                } else {
                    this.$refs.playPause.attributes.d.value = "M18 12L0 24V0";
                    this.$refs.player.pause();
                }
            },
            makePlay() {
                this.$refs.playpauseBtn.style.display = 'block';
            }
        }
    }
</script>

<style scoped lang="scss">
  body {
    margin: 0;
  }

  .holder {
    display: flex;
    flex-direction: column;
    width: 100%;
    align-items: center;

    .get-it-on-github {
      margin-top: 24px;
      margin-bottom: 24px;
      font-family: 'Roboto';
      color: #55606E;
    }
  }

  .audio.green-audio-player {
    width: 100%;
    height: 40px;
    box-shadow: 0 4px 16px 0 rgba(0, 0, 0, .07);
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-right: 24px;
    border-radius: 4px;
    user-select: none;
    -webkit-user-select: none;

    .play-pause-btn {
      display: none;
      cursor: pointer;
    }

    .spinner {
      width: 18px;
      height: 18px;
      background-image: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/355309/loading.png);
      background-size: cover;
      background-repeat: no-repeat;
      animation: spin 0.4s linear infinite;
    }

    .slider {
      flex-grow: 1;
      background-color: #D8D8D8;
      cursor: pointer;
      position: relative;

      .progress {
        background-color: #44BFA3;
        border-radius: inherit;
        position: absolute;
        pointer-events: none;

        .pin {
          height: 16px;
          width: 16px;
          border-radius: 8px;
          background-color: #44BFA3;
          position: absolute;
          pointer-events: all;
          box-shadow: 0px 1px 1px 0px rgba(0, 0, 0, 0.32);
        }
      }
    }

    .controls {
      font-family: 'Roboto', sans-serif;
      font-size: 16px;
      line-height: 18px;
      display: flex;
      flex-grow: 1;
      justify-content: space-between;
      align-items: center;
      margin-left: 24px;
      margin-right: 24px;

      .slider {
        margin-left: 16px;
        margin-right: 16px;
        border-radius: 2px;
        height: 4px;

        .progress {
          width: 0;
          height: 100%;

          .pin {
            right: -8px;
            top: -6px;
          }
        }
      }

      span {
        cursor: default;
      }
    }

    .volume {
      position: relative;

      .volume-btn {
        cursor: pointer;

        &.open path {
          fill: #44BFA3;
        }
      }

      .volume-controls {
        width: 30px;
        height: 135px;
        background-color: rgba(0, 0, 0, 0.62);
        border-radius: 7px;
        position: absolute;
        left: -3px;
        bottom: 52px;
        flex-direction: column;
        align-items: center;
        display: flex;

        &.hidden {
          display: none;
        }

        .slider {
          margin-top: 12px;
          margin-bottom: 12px;
          width: 6px;
          border-radius: 3px;

          .progress {
            bottom: 0;
            height: 100%;
            width: 6px;

            .pin {
              left: -5px;
              top: -8px;
            }
          }
        }
      }
    }
  }

  svg, img {
    display: block;
  }

  @keyframes spin {
    from {
      transform: rotateZ(0);
    }
    to {
      transform: rotateZ(1turn);
    }
  }


</style>
