<template>
  <div id="my-container">
    <div>
      <!-- Our triggering (target) element -->
      <b-icon icon='cart4' font-scale='2.5' id="popover-reactive-1" ref="button" @click="loadingData()"></b-icon>
    </div>
    <!-- Our popover title and content render container -->
    <!-- We use placement 'auto' so popover fits in the best spot on viewport -->
    <!-- We specify the same container as the trigger button, so that popover is close to button -->
    <b-popover
      custom-class="wide-popover"
      target="popover-reactive-1"
      triggers="click"
      :show.sync="popoverShow"
      placement="auto"
      container="my-container"
      ref="popover"
    >
      <template #title>
        <b-button @click="onClose" class="close" aria-label="Close">
          <span class="d-inline-block" aria-hidden="true">&times;</span>
        </b-button>
        訂購餐廳：{{bookingShopName}}
      </template>
      <div v-for="(item,index) in ItemList" :key="index" class="productbd" >
        <CartCell v-on:deleteclick="deleteCartCell" @spinClick="modifySpinValue" @deleteCoupon='deleteCoupon' v-bind="item" :index="index"/>
      </div>
      <!-- <b-button @click="add" variant="outline-info" vertical>+</b-button> -->
        <div class='tlprice' id='coupon' v-if="productNum!= 0">
          <b-input-group
              size="sm"
              class="mb-3"
              prepend="優惠券"
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
        <div class="row" v-if="productNum!= 0">
          <div class='col-md-9 tlprice'>小計(共{{productNum}}項餐點)</div>
          <div class='col-md-3 tlprice' style="text-align: end;">{{beforePrice}}</div>
        </div>
        <div class="row " v-if="productNum!= 0">
          <div class='col-md-9 tlprice'>折扣</div>
          <div class='col-md-3 tlprice' style="text-align: end;">{{disCountMoney}}</div>
        </div>
        <div class="row " v-if="productNum!= 0">
          <div class='col-md-9 tlprice'>運費</div>
          <div class='col-md-3 tlprice' v-if="fee != 0" style="text-align: end;">{{fee}}</div>
          <div class='col-md-3 tlprice' v-else style="text-align: end;">免運</div>
        </div>
        <div class="row " v-if="productNum!= 0">
          <div class='col-md-9 tlprice'>總計 (包含稅項) :</div>
          <div class='col-md-3 tlprice' style="text-align: end;">{{totalPrice+fee}}</div>
        </div>
        <div class="row col-md-12" >
          <b-button id="checkSb" class="checkOut" @click="onOk" variant="info" :disabled="submitInvalid" vertical>結帳</b-button>
        </div>
      <!-- <b-nav-item @click="onOk" variant="outline-info" vertical>
        <router-link :to="{name: 'Cashier'}" class="nav-link">Ok</router-link>
      </b-nav-item> -->
      <!--div>
        <b-alert show class="small">
          <strong>Current Values:</strong><br>
          Name: <strong>{{ input1 }}</strong><br>
          Color: <strong>{{ input2 }}</strong>
        </b-alert>
      </div-->
    </b-popover>
  </div>
</template>

<script>
  import LoginForm from '@/components/LoginForm.vue';
  import CartCell from "@/components/CartCell.vue";
  export default {
    name:"ShoppingCart",
    components: {
        CartCell
    },
    data() {
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
            id:null
          }
        ],
        beforePrice:null,
        totalPrice: null,
        popoverShow: false,
        submitInvalid: false,
        disCountMoney: 0,
        productNum: null,
        errorMessage: '',
        fee: 30
      }
    },
    methods: {
      loadingData(){
        this.ItemList = [];
        this.totalPrice = 0;
        this.productNum = 0;
        this.disCountMoney = 0;
        this.coupon = null;
        this.couponState = null;
        this.submitInvalid = false;
        let data = JSON.parse(this.$cookie.get("product"));
        let coupon = JSON.parse(this.$cookie.get('coupon'));
        this.bookingShopName = this.$cookie.get('shopName')
        if(data == null) this.submitInvalid = true;
        else {
          for (var i = 0; i<data.length;i++)
          {
            this.beforePrice = this.totalPrice + data[i].foodPrice*data[i].quantity;
            this.totalPrice = this.beforePrice
            this.ItemList.push({foodName:data[i].foodName, quantity:data[i].quantity, foodPrice:data[i].foodPrice, id:data[i].id});
            this.productNum += this.ItemList[i].quantity
          }
        }
        if(coupon != null)
        {
          this.coupon = coupon.coupon.code;
          this.useValidCoupon()
          this.useCouponDiscount(coupon)
          this.$cookie.set('discount',Math.round(this.disCountMoney), {path: "/"})
        }
      },
      dataToCashier(){
        return this.ItemList;
      },
      checkLogin(){
        let loginStatus = !(this.$store.getters['auth/token'] == null);
        if (!loginStatus){
          this.$fire({
            type: 'warning',
            title: '請先登入',
            text: '您必須登入後才能使用此功能',
            confirmButtonText:'`登入',
          }).then(r => {
            this.showModal()
          });
        }
        return loginStatus;
      },
      useCouponDiscount(coupon){
        this.disCountMoney = 0;
        let products = JSON.parse(this.$cookie.get('product'))
        if (coupon.coupon.type == 0)
          this.fee = 0
        else if (coupon.coupon.type == 1)
        {
          this.disCountMoney = Math.floor(this.beforePrice * (100 - coupon.coupon.discount*100)/100);
          this.totalPrice = this.totalPrice - this.disCountMoney
        }
        else if (coupon.coupon.type == 2)
        {
          for (let i = 0 ; i<coupon.coupon_items.length; i++){
            let product = products.filter(j => j.id == coupon.coupon_items[i].product_id)
            this.disCountMoney += coupon.coupon_items[i].quantity * coupon.coupon.discount * product[0].foodPrice
          }
          this.totalPrice -= this.disCountMoney;
        }
      },
      checkCoupon(coupon){
        if(this.checkLogin()){
          let id = this.$cookie.get('shopId');
          let orderItems = this.$cookie.get('product')
          // console.log(orderItems)
          let data = { coupon_code:coupon,seller_id:id,orderItems:orderItems,total_price:this.beforePrice}
          this.$http.post('/customer/coupon/use',data , {
            headers: {
              'Authorization': 'Bearer ' + this.$store.getters['auth/token']
            }
          })
          .then(response =>{
            this.$confirm('輸入優惠券後無法更改商品，欲修改商品請先移除優惠券。','使用說明','warning').then(()=>{
              this.useValidCoupon()
              this.useCouponDiscount(response.data.coupon)
              this.$cookie.set('coupon',JSON.stringify(response.data.coupon), {path: "/"})
              this.$cookie.set('discount',this.disCountMoney, {path: "/"})
              this.$alert('','輸入成功','success')
            })
          })
          .catch(error => {
            // console.log(error.response)
            this.couponState = false
            this.errorMessage = error.response.data.message
          })
        }
      },
      useValidCoupon(){
        function setCouponReadOnly()
        {
          let coupon_input = document.querySelector('#coupon-input')
          if(coupon_input == null) {
            setTimeout(setCouponReadOnly.bind(this),100)
          }
          else {
            coupon_input.setAttribute("readOnly","true");
          }
        }
        setCouponReadOnly()
        this.lockChagneButton()
        this.couponState = true;
      },
      lockChagneButton(){
        this.$bus.$emit("lockbutton")
      },
      unlockChangeButton(){
        this.$bus.$emit("unlockbutton")
      },
      modifyCoupon(){
        this.deleteCoupon()
      },
      modifySpinValue(index,value){
        let productCookie = JSON.parse(this.$cookie.get("product"));
        productCookie[index].quantity = value
        document.cookie = 'product=; expires=Thu, 01 Jan 1970 00:00:00 GMT';
        this.$cookie.set('product', JSON.stringify(productCookie), {path: "/"})
        this.beforePrice = this.beforePrice + (value - this.ItemList[index].quantity) * this.ItemList[index].foodPrice
        this.totalPrice = this.beforePrice - this.disCountMoney
        this.productNum += value - this.ItemList[index].quantity
        this.ItemList[index].quantity = value;
      },
      deleteCartCell(e){
        this.productNum -= this.ItemList[e].quantity
        this.beforePrice = this.beforePrice - this.ItemList[e].foodPrice*this.ItemList[e].quantity;
        this.totalPrice = this.beforePrice;
        this.ItemList.splice(e,1);
        if(this.totalPrice == 0) {
          this.bookingShopName = null;
          this.totalPrice = null;
          }
        if(this.ItemList.length == 0) //delete cookie
        {
          this.submitInvalid = true
          document.cookie = 'shopId=; expires=Thu, 01 Jan 1970 00:00:00 GMT';
          document.cookie = 'shopName=; expires=Thu, 01 Jan 1970 00:00:00 GMT';
          document.cookie = 'product=; expires=Thu, 01 Jan 1970 00:00:00 GMT';
        }
        else{ this.$cookie.set('product',JSON.stringify(this.ItemList), {path: "/"});}
      },
      deleteCoupon(){
        let coupon_input = document.querySelector('#coupon-input')
        this.couponState = null;
        this.disCountMoney = 0;
        this.fee = 30;
        this.totalPrice = this.beforePrice
        this.unlockChangeButton()
        coupon_input.removeAttribute("readOnly");
        document.cookie = 'coupon=; expires=Thu, 01 Jan 1970 00:00:00 GMT';
        document.cookie = 'discount=; expires=Thu, 01 Jan 1970 00:00:00 GMT';
      },
      showModal() {
        this.$bvModal.show('login-modal')
      },
      confirmModal() {
        this.$bus.$emit("cashier",this.dataToCashier());
      },
      onClose() {
        this.popoverShow = false
      },
      onOk() {
        if(this.checkLogin()){
          this.confirmModal()
          this.onClose()
          this.$cookie.set('beforePrice', this.beforePrice, {path: "/"})
          this.$cookie.set('totalPrice', this.totalPrice, {path: "/"})
          if (this.$router.currentRoute['name'] == "Cashier") window.location.reload();
          else this.$router.push("/cashier");
        }
      },
      add(name,spinValue,price)
      {
        this.ItemList.push(
        {
            foodName: name,
            foodPrice: price,
            quantity: spinValue,
        })
      },
      handleScroll ()
      {
        this.onClose();
      },
      handleopen ()
      {
      }
    },
    watch: {
      $route: {
        handler: function() {
          this.onClose()
        },
      }
    },
    created(){
    },
    mounted () {
      var button = document.querySelector(".container")
      button.addEventListener('click',this.handleScroll );
    },
  }
</script>
<style scoped>
  ::placeholder {
    font-size: 12px;
  }
  .error_msg{
    margin: 0;
    font-size: 12px;
  }
  .mb-3{
    padding: 0 0 10px 0;
    margin: 0 !important;
  }
  .col-md-2{
    padding: 0;
  }
  .col-md-3{
    padding: 0;
  }
  .col-md-9{
    padding: 0;
  }
  .productbd{
    padding-bottom: 5px;
  }
  .form-control-sm {
    padding:0;
  }
  .tlprice{
    align-items: center;
    font-size:16px;
  }
  .checkOut{
    width: 100%;
  }
  .row{
    padding:0 0 10px 0;
    margin: 0;
  }
  .wide-popover {
    min-width:25%;
  }
  #popover-reactive-1 {
    color: rgba(255, 255, 255, 0.5);
    background-color: transparent;
  }
  #popover-reactive-1:hover {
    color: rgba(255, 255, 255, 0.75);
    border-color: rgba(255, 255, 255, 0.75);
  }
  #popover-reactive-1:focus {
    box-shadow: none;
  }
</style>
