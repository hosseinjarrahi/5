<template>
  <div
    class="col-12 col-md-4 p-2 w-100 position-relative d-flex flex-column"
    style="cursor: pointer"
    @click="redirect"
  >
    <div class="offer" v-if="product.offer>0">
      <img src="/img/offer.svg" class="img-fluid" alt="offer"/>
    </div>
    <div
      class="my-2 rounded light-shadow h-100 d-flex flex-column justify-content-between course-card bg-light overflow-hidden"
    >
      <div class="course-header shadow" :style="{backgroundImage:`url('${product.pic}')`}"></div>

      <div class="p-3 d-flex flex-column h-100">
        <h2 style="font-size:1rem" class="text-justify p-1 m-1 mb-3">{{ product.title }}</h2>

        <slot name="avatar">
          <p class="pb-2" v-if="product.user.profile">
            <span style="font-size:0.8rem">
              <img :src="avatar" class="shadow avatar" :alt="product.user.name"/>
              <span>استاد:</span>
              <span>{{ product.user.name }}</span>
            </span>
          </p>
        </slot>

        <slot name="footer">
          <div class="d-flex h-100 w-100 flex-column justify-content-end align-items-center ">
            <div
              class="dark-top-border w-100 position-relative d-flex justify-content-center  "
            >
              <span class="d-flex flex-row justify-content-center">
                <span class="btn btn-inset btn-success py-0" v-if="product.offer > 0">
                  <span>{{ product.offer }} تومان</span>
                </span>
                <span
                  :class="['py-0',{'floating':product.offer > 0,'btn btn-inset bg-dark-gray':product.offer <= 0}]"
                >
                  <span
                    :class="[{'line-throgh text-muted':product.offer > 0}]"
                  >{{ product.price }} تومان</span>
                </span>
              </span>
            </div>
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
            product: {default: null}
        },
        computed:{
            avatar(){
                if(this.product.user.profile.avatar)
                  return this.product.user.profile.avatar;
                return '/img/avatar.svg';
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
