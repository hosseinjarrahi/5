<template>
  <div class="container">
    <div class="row justify-content-between">

      <div class="col-12 col-md-8">

        <div class="bg-gray slider overflow-hidden shadow">

          <transition name="fade">
              <a 
                v-for="(slide,index) in slides" 
                :key="index"
                v-if="selected == index"
                href=""
                class="item"
                style="background-image: url('/img/test.jpg');background-size:contain;">
              </a>
          </transition>

          <div class="controlls p-2">
            <span class="prev" @click="next()"><span class="fas fa-angle-right"></span></span>
            <span class="next" @click="previous()"><span class="fas fa-angle-left"></span></span>
          </div>
        </div>

      </div>

      <div class="col-12 col-md-4">

        <div class="my-1 my-md-0 bg-dark-gray aside-slider overflow-hidden shadow">

        </div>

      </div>

    </div>
  </div>
</template>

<script>
    export default {
        name: "AppSlider",
        data() {
            return {
                slides: [
                    {
                        to: 'Slide 1',
                        id: 1
                    },
                    {
                        to: 'Slide 2',
                        id: 2
                    },
                    {
                        to: 'Slide 3',
                        id: 3
                    },
                    {
                        to: 'Slide 4',
                        id: 4
                    },
                    {
                        to: 'Slide 5',
                        id: 5
                    }
                ],
                selected: 0,
                timer: null,
                duration: 5
            }
        },
        created() {
            this.initSlider();
        },
        methods: {
            next() {
                if (this.selected == this.slides.length - 1)
                    this.selected = 0;
                this.selected++;
                this.resetTimer();
            },
            previous() {
                if (this.selected == 0)
                    this.selected = this.slides.length;
                this.selected--;
                this.resetTimer();
            },
            initSlider() {
                this.timer = setInterval(() => {
                    this.next();
                }, this.duration * 1000);
            },
            resetTimer() {
                clearInterval(this.timer);
                this.initSlider();
            }
        }
    }
</script>

<style scoped>
  .slider {
    border-radius: 20px;
    width: 100%;
    padding-top: 50%;
    position: relative;
  }

  .aside-slider {
    width: 100%;
    height: 100%;
    border-radius: 20px;
  }

  .fade-enter-active, .fade-leave-active {
    transition: all 1s;
  }

  .fade-enter
  {
    transform: translateX(100%);
  }

  .fade-leave-to {
    opacity: 0;
  }

  .prev, .next {
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: rgba(255, 255, 255, 0.5);
    padding: 10px;
    width: 30px;
    height: 30px;
    border-radius: 100%;
    cursor: pointer;
  }

  .controlls, .item {
    position: absolute;
    display: flex;
    width: 100%;
    height: 100%;
    justify-content: space-between;
    align-items: center;
    top: 0;
  }
</style>