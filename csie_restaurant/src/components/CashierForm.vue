<template>
    <b-form @submit="onSubmit" @reset="onReset">
        <b-form-group label="支付方式:" label-for="payment">
            <b-form-radio v-model="selected" name="pay" value="1">信用卡</b-form-radio>
            <b-form-radio v-model="selected" name="pay" value="2">現金支付  </b-form-radio>
        </b-form-group>
        <b-form-group label="優惠碼:" label-for="coupon">
            <div class='tlprice' id='coupon'>
            <b-input-group
                size="md"
                class="mb-3"
                >
            <b-form-input id="coupon-input" v-model="coupon" :placeholder="prompt" :state="couponState" aria-describedby='coupon-error' trim></b-form-input>
            <b-input-group-append >
              <b-button size="sm" v-if="couponState==null || !couponState" id="coupon_submit" text="Button" variant="success" @click="checkCoupon(coupon)">使用</b-button>
              <b-button size="sm" v-else id="coupon_submit" text="Button" variant="success" @click="modifyCoupon">修改</b-button>
            </b-input-group-append>
            <b-form-invalid-feedback id='coupon-error' class='error_msg'>
                  {{errorMessage}}
           </b-form-invalid-feedback>
          </b-input-group>
        </div>
        </b-form-group>
        <b-button type="submit">Submit</b-button>
    </b-form>
</template>

<script>
export default {
  name: "Cashier",
  components: {
  },
  data(){
      return {
        coupon: null,
        couponState: null,
        prompt:'請輸入優惠卷',
        bookingShopName: null,
        CouponItems:[],
        ItemList:[
          {
            foodName: null,
            foodPrice: null,
            quantity: null,
          }
        ],
        totalPrice: null,
        popoverShow: false,
        errorMessage: ''
      }
  },
}
</script>