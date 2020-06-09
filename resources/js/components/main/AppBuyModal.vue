<template>
  <div>
    <app-modal @close="$emit('close')" title="خرید" icon="shopping-bag">

      <div class="d-flex flex-row justify-content-between">
        <div>قیمت</div>
        <div class="float-left">
          <span>{{ price }}</span>
          <span>تومان</span>
        </div>
      </div>
      <hr>
      <div class="d-flex flex-row justify-content-between">
        <div>قیمت نهایی</div>
        <div>
          <span>{{ final }}</span>
          <span>تومان</span>
        </div>
      </div>

      <template v-if="showCouponBox">
        <div class="mt-4 form-group">
          <div class="input-group">
            <input placeholder="کد تخفیف" class="no-shadow left-horizon form-control" v-model="coupon"/>
            <span class="input-group-append p-2 px-3 d-flex flex-row align-items-center justify-content-center right-horizon text-white pointer bg-success"
                  @click="checkCoupon">
                  <span class="fas fa-check"></span>
                </span>
          </div>
          <span class="text-danger text-muted">{{ message }}</span>
        </div>
      </template>

      <a class="btn btn-primary btn-block" href>
        <span class="fas fa-check-circle"></span>
        <span>پرداخت</span>
      </a>
    </app-modal>
  </div>
</template>

<script>

    export default {
        props: ['productId', 'price', 'showCouponBox'],
        data() {
            return {
                coupon: null,
                offer: 0,
                message: null,
            };
        },
        methods: {
            checkCoupon() {
                this.load();
                this.message = null;
                axios
                    .post("/check-coupon", {
                        coupon: this.coupon,
                        productId: this.productId
                    })
                    .then(res => {
                        this.offer = res.data.offer;
                        this.message = res.data.message;
                    })
                    .catch(err => this.message = err.response.data.message)
                    .then(() => {
                        this.closeLoad();
                    });
            }
        },
        computed: {
            final() {
                return this.price * (100 - this.offer) / 100;
            }
        }
    };
</script>

<style>
</style>
