<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-11 col-md-6 p-3 bg-dark-gray shadow rounded my-2">
        <img :src="'/'+img" class="w-100" v-if="img"/>

        <h4 class="border border-white rounded p-2 shadow text-center">{{ type == 'test' ? 'تستی' : 'تشریحی' }}</h4>

        <p class="text-justify p-3">
          <span>{{ number }}-</span>
          <vue-mathjax :formula="desc"></vue-mathjax>
        </p>

        <ul class="list-group" v-if="type == 'test'">
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
  props: {
    desc: { default: "" },
    img: { default: "" },
    A: { default: "" },
    B: { default: "" },
    C: { default: "" },
    D: { default: "" },
    type: { default: "" },
    id: { default: "" },
    number: { default: "" }
  },
  data() {
    return {
        selected: null,
        description:null
    };
  },
  methods: {
    select(witchOne){
      let id = this.id;
      if(this.selected != witchOne)
      this.$emit('change',{
        id:id ,
        selected:witchOne ,
        });

      this.selected = witchOne;
    }
  }
};
</script>

<style scoped lang="scss">
@import './../../sass/app.scss';

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
  background-color: $red;
}
.type {
  background: #ede574;
}
ul{
  li{
    color: $darkGray;
  }
  li::before {
    counter-increment: section;
    content: counter(section) ": ";
  }
  counter-reset: section;
}
</style>
