<template>
    <b-form>
        <b-form-group label="碰面地點:" label-for="payment" >
          <b-form-radio-group
            id="radio-group-1"
            v-model="placeSelected"
            @change="onChange"
            :options="places"
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
              button-variant="outline-dark"
              buttons
              stacked
            ></b-form-radio-group>
            <div class="adb">
              <b-icon animation="cylon" variant="secondary" @mouseleave="adHover=false" v-if="adHover" icon="plus-circle-fill" font-scale="3" @click="addAddress"/>
              <b-icon variant="secondary" @mouseover="adHover=true" v-else icon="plus-circle" font-scale="3" @click="addAddress"/>
            </div>
          </div>
        </b-form-group>
        <b-modal
          id="modal-prevent-closing"
          ref="modal"
          title="新增地址"
          @show="resetModal"
          @hidden="resetModal"
          @ok="handleAddress"
          centered
        >
          <form ref="form" @submit.stop.prevent="handleAddress">
            <b-form-group
              label="您的地址："
              label-for="name-input"
              :state="addressState"
            >
              <b-form-input
                id="name-input"
                v-model="newAddress"
                :state="addressState"
                required
              ></b-form-input>
            </b-form-group>
          </form>
        </b-modal>

        <b-form-group label="支付方式：" label-for="payment">
          <b-form-radio-group v-model="paymentMethodSelected" @change="onChange" :options="paymentMethods"></b-form-radio-group>
        </b-form-group>
        <b-form-group>
          <b-input-group-prepend v-if="paymentMethodSelected==1">
            <b-form-select class="col-11" v-model="creditCardSelected" @change="onChange" :options="creditCards"></b-form-select>
            <b-button class="creditCard col-1" size="sm" text="Button" variant="success" @click="addCreditCard" squared>+</b-button>
          </b-input-group-prepend>
        </b-form-group>
        <b-modal
          id="modal-credit-card"
          ref="credit"
          title="新增信用卡"
          @show="resetModal"
          @hidden="resetModal"
          @ok="handleCreditCard"
          centered
        >
          <form ref="credit_form" @submit.stop.prevent="handler2">
            <b-form-group
              label="您的信用卡卡號："
              label-for="name-input2"
              :state="creditCardState"
            >
              <b-input-group>
                <b-input-group-prepend is-text>
                  <b-icon icon="credit-card"></b-icon>
                </b-input-group-prepend>
                <b-form-input
                  id="name-input2"
                  v-model="creditCard"
                  :state="creditCardState"
                  required
                ></b-form-input>
              </b-input-group>
            </b-form-group>
            <b-form-group
              label="到期日："
              label-for="name-input3"
              :state="expiredDateState"
            >
            <b-input-group>
              <datepicker minimum-view="month" name="uniquename" required clear-button v-model="expiredDate" format="MM/yy" typeable></datepicker>
            </b-input-group>
            </b-form-group>
          </form>
        </b-modal>
        
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
import Datepicker from 'vuejs-datepicker';
export default {
  name: "Cashier",
  components: {
    Datepicker
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
        paymentMethods: [
          {text: "信用卡", value: 1},
          {text: "現金支付", value: 2}
        ],
        address:[],
        totalPrice: null,
        popoverShow: false,
        errorMessage: '',
        adHover:false,
        newAddress: '',
        addressState: null,
        paymentMethodSelected: 1,
        creditCardSelected: '請選擇信用卡',
        creditCard: '',
        creditCardState: null,
        creditCards: [
          {text: "請選擇信用卡", value: "請選擇信用卡", disabled: true},
          {text: "sample", value: "sample"}
        ],
        expiredDate: '',
        expiredDateState: null
      }
  },
  methods:{
    formatter(value) {
      return moment(value).format("M");
    },
    onContext(ctx){
      console.log(ctx)
    },
    onChange(){
      let address = null;
      let coupon_code = null;
      let payment_method = null;

      if (this.placeSelected.value === 'school')
        address = this.schoolPlaceSelected.text
      else if (this.placeSelected.value === 'outside')
        address = this.addressSelected.text;

      if (this.couponState)
        coupon_code = this.coupon
      console.log(this.paymentMethodSelected)
      //this.$bus.$emit('sync', {address:address, payment_method:payment_method, coupon_code:coupon_code})
    },
    school(){
      console.log(this.placeSelected)
    },
    addAddress(){
      this.$refs['modal'].show();
    },
    addCreditCard(){
      this.$refs['credit'].show();
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
        this.addressSelected = this.address[0].value;
      })
    },
    checkAddressValidity() {
      const valid = this.$refs.form.checkValidity()
      this.addressState = valid
      return valid
    },
    checkCreditCardValidity() {
      const valid = this.$refs.credit_form.checkValidity()
      this.creditCardState = valid;
      if (this.expiredDate)
        this.expiredDateState = true;
      else
        this.expiredDateState = false;
      return valid && this.expiredDateState
    },
    resetModal() {
      this.newAddress = ''
      this.addressState = null
      this.creditCard = ''
      this.creditCardState = null
      this.expiredDate = ''
    },
    handleCreditCard(bvModalEvt) {
      bvModalEve.preventDefault()
      this.handler2()
    },
    handler2() {
      if (!this.checkCreditCardValidity())
        return
      for (let i = 0 ; i<this.creditCards.length; i++){
        if(this.creditCard == this.creditCards[i].value){
          this.$alert("重複的信用卡，請重新輸入","","warning")
          this.creditCardState = false 
          return
        }
      }
      this.creditCards.push(this.creditCard)
      console.log(this.creditCards)
      this.$nextTick(() => {
        this.$bvModal.hide('modal-credit-card')
      })
    },
    handleAddress(bvModalEvt) {
      // Prevent modal from closing
      bvModalEvt.preventDefault()
      // Trigger submit handler
      this.handler1()
    },
    handler1() {
      if (!this.checkAddressValidity()) {
        return
      }
      for (let i = 0 ; i<this.address.length; i++){
        if(this.newAddress == this.address[i].value){
          this.$alert("重複的地址，請重新輸入","","warning")
          this.addressState = false 
          return
        }
      }
      this.address.push(this.newAddress)
      console.log(this.address)
      this.$nextTick(() => {
        this.$bvModal.hide('modal-prevent-closing')
      })
    }
  },
  created(){
    this.getCutomerAddress();
  }
}
</script>

<style scoped>
  .adb{
    margin: 2%;
    text-align:center;
  }
  .rdb{
    width: 100%;
  }
  .placetxt{
    margin-bottom: 1%;
  }
  .outside{
    margin: 2%;
  }
  .creditCard{
    font-size: 1.2rem;
  }
</style>