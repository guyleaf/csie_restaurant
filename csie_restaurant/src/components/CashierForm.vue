<template>
    <b-form @submit="onSubmit" @reset="onReset">
        <b-form-group label="支付方式:" label-for="payment">
            <b-form-radio v-model="selected" name="pay" value="1">信用卡</b-form-radio>
            <b-form-radio v-model="selected" name="pay" value="2">現金支付  </b-form-radio>
        </b-form-group>
        <b-form-group label="優惠碼:" label-for="coupon">
            <b-form-input id="coupon" v-model="coupon" type="text" size="lg" placeholder="輸入優惠碼"></b-form-input>
        </b-form-group>
        <b-button type="submit">Submit</b-button>
    </b-form>
</template>

<script>
export default {
  name: "Cashier",
  components: {
  },
}
</script>