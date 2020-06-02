<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-11 col-md-6 p-3 bg-dark-gray shadow rounded my-2">

        <img :src="img" class="w-100" @click="zoom=true" v-if="img"/>

        <div class="d-flex flex-row justify-content-center align-items-center position-fixed h-100 w-100"
             style="background-color:rgba(0,0,0,0.8);z-index:500;top:0;left:0" v-if="zoom">
          <div class="position-absolute display-4" @click="zoom=false" style="left: 20px;top:10px">&times</div>
          <img :src="img" class="w-100" v-if="img"/>
        </div>

        <h4 class="border border-white rounded p-2 shadow text-center">{{ type == 'test' ? 'تستی' : 'تشریحی' }}</h4>

        <p class="text-justify p-3">
          <span>{{ number }}-</span>
          <vue-mathjax :formula="desc" style="white-space: pre-wrap"></vue-mathjax>
        </p>

        <ul class="list-group" ref="ul" v-if="type == 'test'">
          <li :class="['list-group-item',{'select':selected == 'A'}]" @click="select('A')">
            <vue-mathjax :formula="A"></vue-mathjax>
          </li>
          <li :class="['list-group-item',{'select':selected == 'B'}]" @click="select('B')">
            <vue-mathjax :formula="B"></vue-mathjax>
          </li>
          <li :class="['list-group-item',{'select':selected == 'C'}]" @click="select('C')">
            <vue-mathjax :formula="C"></vue-mathjax>
          </li>
          <li :class="['list-group-item',{'select':selected == 'D'}]" @click="select('D')">
            <vue-mathjax :formula="D"></vue-mathjax>
          </li>
        </ul>

      </div>
    </div>
  </div>
</template>

<script>
    export default {

        mounted() {
            this.makeRandom();
        },

        props: {
            desc: {default: ""},
            img: {default: ""},
            A: {default: ""},
            B: {default: ""},
            C: {default: ""},
            D: {default: ""},
            type: {default: ""},
            id: {default: ""},
            number: {default: ""},
            zoom:false
        },

        data() {
            return {

                selected: null,
                description: null

            };
        },

        methods: {
            select(witchOne) {
                let id = this.id;
                if (this.selected != witchOne)
                    this.$emit('change', {
                        id: id,
                        selected: witchOne,
                    });

                this.selected = witchOne;
            },

            makeRandom(){
                let ul = this.$refs.ul;

                for (let i = ul.children.length; i >= 0; i--) {
                    ul.appendChild(ul.children[Math.random() * i | 0]);
                }
            }

        }
    };
</script>

<style scoped lang="scss">

  .time {
    position: absolute;
    bottom: 0;
    left: 0;
    color: white;
    background: #ff416c; /* fallback for old browsers */
    background: -webkit-linear-gradient(
        to right,
        #ff4b2b,
        #ff416c
    ); /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(
        to right,
        #ff4b2b,
        #ff416c
    ); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
  }

  @media only screen and (max-width: 980px) {
    .block-btn {
      text-align: center;
      position: relative;
      margin: 10px 0px;
      display: block;
    }
  }

  .select {
    background-color: #dc3545;
    color: white;
  }

  .type {
    background: #ede574;
  }

  ul {
    li {
      color: #2f3542;
    }
  }
  .zoom{
    position: absolute;
    top: 0;
    bottom: 0;
    z-index: 500;
    width:100%;
  }
</style>
