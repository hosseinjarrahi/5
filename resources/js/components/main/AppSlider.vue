<template>
  <div class="container">
    <div class="row justify-content-between">

      <div class="col-12 col-md-8">

        <div class="bg-gray slider overflow-hidden">

          <transition name="fade">
              <a
                v-for="(slide,index) in slides"
                :key="index"
                v-if="selected == index"
                :href="slide.link"
                class="item"
                :style="{backgroundImage:`url(${slide.pic})`}">
              </a>
          </transition>

          <div class="controlls p-2">
            <span class="prev" @click="next()"><span class="fas fa-angle-right"></span></span>
            <span class="next" @click="previous()"><span class="fas fa-angle-left"></span></span>
          </div>
        </div>

      </div>

      <div class="col-12 col-md-4">

        <div class="my-2 my-md-0 bg-dark-gray aside-slider h-md-auto pp overflow-hidden"
        :style="{backgroundImage: `url(${event.body})`}">
        </div>

      </div>

    </div>
  </div>
</template>

<script>
    export default {
        name: "AppSlider",
        created(){
          console.log(this.event);
        },
        props:{
          slides:{default:[]},
            event:{default: ''}
        },
        data() {
            return {
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
                if (this.selected == this.slides.length-1)
                  this.selected = 0;
                else
                  this.selected++;
                this.resetTimer();
            },
            previous() {
                if (this.selected == 0)
                  this.selected = this.slides.length-1;
                else
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
    background-size: cover;
    background-position: center;
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
    z-index: 2;
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
  .item{
    background-size:contain;
    z-index: 1;
  }
  .pp{
    padding-top: 100%;
  }
</style>
