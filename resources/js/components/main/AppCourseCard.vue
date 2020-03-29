<template>
  <div
    class="col-12 col-md-4 p-2 w-100 position-relative"
    style="cursor: pointer"
    @click="redirect"
  >
    <div class="offer" v-if="product.offer>0">
      <img src="/img/offer.svg" class="img-fluid" alt="offer" />
    </div>
    <div class="my-2 rounded shadow course-card overflow-hidden">
      <div class="course-header shadow" :style="{backgroundImage:`url('${product.pic}')`}"></div>

      <div class="p-3">
        <h2 style="font-size:1rem" class="text-justify p-1 m-1 mb-3">{{ product.title }}</h2>

        <slot name="avatar">
          <p class="pb-2">
            <span style="font-size:0.8rem">
              <img :src="product.pic" class="shadow avatar" :alt="product.title" />
              <span>استاد:</span>
              <span>جعفری</span>
            </span>
          </p>
        </slot>

        <slot name="footer">
          <div
            class="d-flex position-relative flex-column justify-content-between align-items-center dark-top-border"
          >
            <span>
              <span class="btn btn-success py-0" v-if="product.offer > 0">
                <span>{{ product.offer }} تومان</span>
              </span>
              <span
                :class="['py-0',{'floating':product.offer > 0,'btn bg-dark-gray':product.offer <= 0}]"
              >
                <span
                  :class="[{'line-throgh text-muted':product.offer > 0}]"
                >{{ product.price }} تومان</span>
              </span>
            </span>
          </div>
        </slot>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "AppCourseCard",
  props: {
    product: { default: null }
  },
  methods: {
    redirect() {
      return (window.location = this.product.url);
    }
  }
};
</script>

<style scoped>
.course-header {
  padding-top: 50%;
  background-position: center;
  background-size: cover;
}
.course-card {
  background-color: #f7f1e3;
  border: 1px dashed #2f3542;
  color: #2f3542 !important;
}
.offer {
  position: absolute;
  top: 1px;
  left: 1px;
  width: 40px;
  height: 40px;
}
.avatar {
  width: 30px;
  height: 30px;
  border-radius: 100%;
}
.line-throgh {
  text-decoration: line-through red;
}
.dark-top-border {
  border-top: 1px #e2e2e2 solid;
  padding-top: 10px;
}
.floating {
  position: absolute;
  top: -10px;
  display: block;
  text-align: center;
  font-size: 0.8rem;
}
</style>