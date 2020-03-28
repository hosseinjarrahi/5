<template>
  <div>
    <app-modal @close="$emit('close')" title="خرید" icon="shopping-bag">
      <table class="table table-striped">
        <tr>
          <td class="col-12">قیمت دوره</td>
          <td>
            <span>{{ price }}</span>
            <span>تومان</span>
          </td>
        </tr>
        <tr>
          <td class="col-12">قیمت نهایی</td>
          <td>
            <span>{{ final }}</span>
            <span>تومان</span>
          </td>
        </tr>
        <tr>
          <td colspan="2" v-if="showCouponBox">
            <div class="form-group">
              <div class="input-group-append">
                <input placeholder="کد تخفیف" class="form-control" v-model="coupon" />
                <span class="input-group-text text-white pointer bg-success" @click="checkCoupon">
                  <span class="fas fa-check"></span>
                </span>
              </div>
              <span class="text-danger text-muted">{{ message }}</span>
            </div>
          </td>
        </tr>
      </table>
      <a class="btn btn-primary btn-block" href>
        <span class="fas fa-check-circle"></span>
        <span>پرداخت</span>
      </a>
    </app-modal>
  </div>
</template>

<script>

export default {
  props: ['productId','price','showCouponBox'],
  data() {
    return {
      coupon: null,
      offer: 0,
      message:null,
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
        .catch(err => this.message = err.response.data.message )
        .then(() => {
          this.closeLoad();
        });
    }
  },
  computed:{
      final(){
        return this.price * ( 100 - this.offer ) / 100;
      }
    }
};
</script>

<style>
</style>