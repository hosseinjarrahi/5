<template>
  <div class="container my-4">
    <div class="row justify-content-center">

      <div class="col-12">
        <div class="bg-dark-gray courses overflow-hidden shadow d-flex flex-column flex-md-row">

          <div class="col-12 col-md-3">
            <img src="/img/courses.png" class="img-fluid" alt="">
          </div>

          <div class="col-md-9 col-12 d-flex flex-column flex-md-row justify-content-around">

            <div class="p-2 col-12 col-md-4">
              <div class="my-2 p-2 rounded" style="background-color: #57606f;">s</div>
            </div>

            <div class="p-2 col-12 col-md-4">
              <div class="my-2 p-2 rounded" style="background-color: #57606f;">s</div>
            </div>

            <div class="p-2 col-12 col-md-4">
              <div class="my-2 p-2 rounded" style="background-color: #57606f;">s</div>
            </div>


          </div>

        </div>
      </div>

      <a href="" class="my-2 col-12 text-center text-white">
        <div class="courses overflow-hidden shadow p-1" style="background-color: #57606f">
          دوره های بیشتر ...
        </div>
      </a>

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
  .courses {
    border-radius: 20px;
    width: 100%;
    position: relative;
  }
</style>