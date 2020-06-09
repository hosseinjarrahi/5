<template>
  <div class="text-white bg-dark-gray shadow rounded position-relative" style="padding-top:150px;">
    <div class="px-4" style="font-size:0.9rem">
      <div class="my-2 border-bottom-dark p-2">
        <span class="fas fa-chalkboard-teacher"></span>
        <span>منتشر کننده :</span>
        <span>{{ product.user.name }}</span>
      </div>

      <div class="my-2 border-bottom-dark p-2" v-if="product.price > 0">
        <span class="fas fa-money-bill"></span>
        <span>قیمت :</span>
        <span>
              <span class="p-1 rounded bg-gray py-0" v-if="product.offer > 0">
                <span>{{ product.offer }} تومان</span>
              </span>
              <span class="p-1 bg-dark-gray py-0">
                <span :class="{'line-throgh':product.offer > 0}">{{ product.price }} تومان</span>
              </span>
            </span>
      </div>

      <div class="my-2 border-bottom-dark p-2" v-if="product.course_items && product.course_items.length">
        <span class="fas fa-file-video"></span>
        <span>فایل های منتشر شده :</span>
        <span>{{ product.course_items.length }}</span>
      </div>

      <div class="my-2 border-bottom-dark p-2" v-if="product.time">
        <span class="fas fa-clock"></span>
        <span>زمان دوره :</span>
        <span>20:50:10</span>
      </div>

      <div class="my-2 border-bottom-dark p-2">
        <span class="fas fa-calendar-minus"></span>
        <span>تاریخ انتشار :</span>
        <span>{{ release }}</span>
      </div>

      <div class="my-2 border-bottom-dark p-2" v-if="product.downloadCount">
        <span class="fas fa-user-graduate"></span>
        <span>تعداد دانلود ها :</span>
        <span>20</span>
        <span>نفر</span>
      </div>

      <div class="my-2 border-bottom-dark p-2" v-if="status">
        <span class="fas fa-spinner"></span>
        <span>وضعیت دوره :</span>
        <span>{{ status }}</span>
      </div>

      <div class="my-2 border-bottom-dark p-2" v-if="product.percentage">
        <span class="fas fa-percentage"></span>
        <span>درصد تکمیل :</span>
        <span class="my-2">
            <div class="progress">
              <div class="progress-bar" :style="{width: `${product.percentage}%`}">{{ product.percentage }}%</div>
            </div>
          </span>
      </div>
    </div>

    <div class="mt-4" v-if="product.price > 0">
      <span class="my-2">
        <div class="btn rounded btn-block btn-success shadow" @click="buyModal = true">
          <span class="fas fa-shopping-bag"></span>
          <span>خرید</span>
        </div>
      </span>
    </div>

    <div class="avatar-parent" v-if="product.pic">
      <div class="pic bg-cover rounded bg-dark-gray shadow" :style="`background-image:url(${product.pic})`"></div>
    </div>

    <app-buy-modal
      @close="buyModal = false"
      v-if="buyModal"
      :productId="product.id"
      :price="product.offer == 0 ? product.price : product.offer"
      :showCouponBox="product.offer == 0"
    ></app-buy-modal>

  </div>
</template>

<script>
    export default {
        name: "AppProductDesc",
        props: {
            product: {default: null},
            release: null
        },
        data() {
            return {
                buyModal: false
            }
        },
        methods: {
            buy() {

            }
        },
        computed: {
            status() {
                switch (this.product.status) {
                    case 'complete':
                        return 'کامل';
                        break;
                    case 'making':
                        return 'در حال برگزاری';
                        break;
                    case 'soon':
                        return 'به زودی';
                        break;
                    default:
                        return null;
                }
            }
        }
    };
</script>

<style scoped>
  .avatar-parent {
    position: absolute;
    top: -50px;
    width: 100%;
    display: flex;
    left: 0;
    right: 0;
    justify-content: center;
  }

  .pic {
    width: 90%;
    height: 200px;
    border: 2px solid #57606f;
  }

  .border-bottom-dark {
    border-bottom: 2px solid #57606f;
  }

  .line-throgh {
    text-decoration: red line-through;
  }

  .bg-cover {
    background-position: center;
    background-size: cover;
  }
</style>
