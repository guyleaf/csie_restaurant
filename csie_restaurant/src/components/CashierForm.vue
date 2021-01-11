<template>
    <b-form>
        <b-form-group label="碰面地點:" label-for="payment" >
          <b-form-radio-group
            id="radio-group-1"
            v-model="placeSelected"
            :options="places"
            :aria-describedby="ariaDescribedby"
            name="radio-options"
         ></b-form-radio-group>
        </b-form-group>

        <b-form-group v-slot="{ ariaDescribedby }">
          <div class="inSchool" v-if="placeSelected=='school'">
             <b-form-select v-model="schoolPlaceSelected" :options="schoolPlaces"></b-form-select>
          </div>
          <div class="outside" v-if="placeSelected=='outside'" >
            <div class="row placetxt"> 您的地點：</div>
            <b-form-radio-group
              class="rdb"
              id="btn-radios-3"
              v-model="addressSelected"
              :options="address"
              :aria-describedby="ariaDescribedby"
              button-variant="outline-info"
              buttons
              stacked
            ></b-form-radio-group>
          </div>
      </b-form-group>
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
              <b-button size="sm" v-if="couponState==null || !couponState" id="coupon_submit" text="Button" variant="success">使用</b-button>
              <b-button size="sm" v-else id="coupon_submit" text="Button" variant="success">修改</b-button>
            </b-input-group-append>
            <b-form-invalid-feedback id='coupon-error' class='error_msg'>
                  {{errorMessage}}
           </b-form-invalid-feedback>
          </b-input-group>
        </div>
        </b-form-group>
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
        placeSelected:'school',
        schoolPlaceSelected:'請選擇地點',
        addressSelected: '0',
        places:[
          { text: "北科大校內", value: "school" },
          { text: "校外地址", value: "outside" },
        ],
        schoolPlaces:[
          { text: "請選擇地點", value: "請選擇地點", disabled:true},
          { text: "綜合科館正門口", value: "綜合科館正門口"},
          { text: "共同科館門口", value: "共同科館門口"},
          { text: "中正館側門口", value: "中正館側門口"},
          { text: "第一教學大樓", value: "第一教學大樓"},
          { text: "第二教學大樓", value: "第二教學大樓"},
          { text: "第三教學大樓", value: "第三教學大樓"},
          { text: "第四教學大樓", value: "第四教學大樓"},
          { text: "第五教學大樓", value: "第五教學大樓"},
          { text: "第六教學大樓", value: "第六教學大樓"},
        ],
        address:[],
        totalPrice: null,
        popoverShow: false,
        errorMessage: ''
      }
  },
  methods:{
    school(){
      console.log(this.placeSelected)
    },
    getCutomerAddress(){
      this.$http.get('/customer/address',  {
        headers: {
          'Authorization': 'Bearer ' + this.$store.getters['auth/token']
        }
      }).then(response =>{
        for (let i = 0; i<response.data.length; i++){
          this.address.push({text:response.data[i].address, value:response.data[i].address})
        }
      })
    }
  },
  created(){
    this.getCutomerAddress();
  }
}
</script>

<style scoped>
  .rdb{
    width: 100%;
  }
  .placetxt{
    margin-bottom: 1%;
  }
  .outside{
    margin: 2%;
  }
</style>