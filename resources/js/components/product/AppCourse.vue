<template>
  <div class="container my-4">
    <div class="row justify-content-center">

      <div class="col-12">
        <div class="bg-dark-gray courses overflow-hidden shadow d-flex flex-column flex-md-row align-items-center">

          <div class="col-12 col-md-3">
            <img :src="mainImage" class="img-fluid" :alt="moreText">
          </div>

          <div class="col-md-9 col-12 d-flex flex-column flex-md-row justify-content-around align-items-center">

            <slot></slot>
            
          </div>

        </div>
      </div>

      <a :href="moreLink" class="my-2 col-12 text-center text-white">
        <div class="courses overflow-hidden shadow p-1 pointer" style="background-color: #57606f">
          {{ moreText }}
        </div>
      </a>

    </div>
  </div>
</template>

<script>
    export default {
        name: "AppSlider",
        props:{
          'mainImage':{default:null},
          'moreText':{default:null},
          'moreLink':{default:null},
        },
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
  .courses {
    border-radius: 20px;
    width: 100%;
    position: relative;
  }
</style>