<template>
  <div class="container-fluid p-3 bg-light shadow rounded my-2">
  <h4 class=" text-center">{{ title }}</h4>
    <p class="mb-5  text-justify">{{ desc }}</p>
    <div class="w-100 mt-3 position-relative">
      <a :href="to" class="block-btn btn btn-outline-primary" v-if="enterToExam">ورود به مسابقه</a>
      <a :href="'/results/'+id" class="block-btn btn btn-outline-primary" v-if="enterToExam">نتایج</a>

      <div class="time p-2 rounded shadow block-btn" style="font-size:0.9rem">
        <span>زمان شروع: </span>
        <span>{{ start }}</span>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  props: {
    title: { default: "" },
    desc: { default: "" },
    to: { default: "" },
    file: { default: "" },
    start: { default: "" },
    id: { default: null }
  },
  data() {
    return {};
  },
  methods: {},
  computed: {
    enterToExam() {
      return true;
      day == 0;
    }
  }
};
</script>

<style scoped>
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

/* Give custom look and feel to file upload*/
.btn-file input[type="file"] {
  position: absolute;
  top: 0;
  right: 0;
  min-width: 100%;
  min-height: 100%;
  opacity: 0;
  outline: none;
  cursor: pointer;
  display: block;
}
.btn-file {
  position: relative;
  overflow: hidden;
  color: #2a476b;
  font-weight: bold;
  background-color: #f1f1ef;
  box-shadow: 1px 10px 20px 0px rgba(218, 215, 206, 0.8);
  border: 2px solid #2a476b;
}
.btn-file:hover {
  background: #2a476b;
  color: #ffffff;
}
.loading {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(10, 10, 10, 0.8);
  display: flex;
  justify-content: center;
  align-content: center;
  align-items: center;
}
@media only screen and (max-width: 980px) {
  .block-btn {
    text-align: center;
    position: relative;
    margin: 10px 0px;
    display: block;
  }
}
</style>
