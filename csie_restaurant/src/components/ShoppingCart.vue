<template>
  <div id="my-container">
    <div class="my-3">
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
        <CartCell v-on:deleteclick="deleteCartCell" @spinClick="modifySpinValue" v-bind="item" :index="index"/>
      </div>
      <!-- <b-button @click="add" variant="outline-info" vertical>+</b-button> -->
        <div class='tlprice' id='coupon'>
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
        <div class="row ">
          <div class='col-md-9 tlprice'>總計 (包含稅項) :</div>
          <div class='col-md-3 tlprice' style="text-align: end;">{{totalPrice}}</div>
        </div>
        <div class="row col-md-12" >
          <b-button class="checkOut" @click="onOk" variant="info" vertical>結帳</b-button>
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
            foodSpinValue: null,
          }
        ],
        totalPrice: null,
        popoverShow: false,
        errorMessage: ''
      }
    },
    methods: {
      parseCookie(){
        let allCookies = JSON.parse(this.$cookie.get("product"));
        return allCookies
      },
      loadingData(){
        this.ItemList = [];
        this.totalPrice = null;
        let data = this.parseCookie();
        let coupon = this.$cookie.get('couponName');
        this.bookingShopName = this.$cookie.get('shopName')
        for (var i = 0; i<data.length;i++)
        {
          this.totalPrice = this.totalPrice + data[i].foodPrice*data[i].quantity;
          this.ItemList.push({foodName:data[i].foodName, foodSpinValue:data[i].quantity, foodPrice:data[i].foodPrice});
        }
        if(coupon != null)
        {
          this.coupon = coupon;
          this.useValidCoupon();
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
            confirmButtonText:'登入',
          }).then(r => {
            this.showModal()
          });
        }
        return loginStatus;
      },
      showModal() {
        this.$bvModal.show('login-modal')
      },
      addCouponToCookie(couponName){
        let id = this.$cookie.get('shopId')
        this.$http.get('restaurants/' + id + '/coupons' + '?include_expired=1'). //FIXME  ?include_expired=1要移除
        then(response => {
            let couponCards = response.data;
            for (let i = 0 ; i<couponCards.length; i++){
              if(couponCards[i].coupon.code === couponName){
                this.$cookie.set('coupon', JSON.stringify(couponCards[i]))
                this.$cookie.set('couponId',couponCards[i].coupon.id);
                this.$cookie.set('couponName',couponCards[i].coupon.code);
                break;
              }
            }
        })
      },
      getCouponItems(couponName){
        let id = this.$cookie.get('shopId')
        this.$http.get('restaurants/' + id + '/coupons' + '?include_expired=1'). //FIXME  ?include_expired=1要移除
        then(response => {
            let couponCards = response.data;
            for (let i = 0 ; i<couponCards.length; i++){
              if(couponCards[i].coupon.code === couponName){
                this.CouponItems = couponCards[i].coupon_items;
                break;
              }
            }
        })
      },
      checkItemsInCoupon(){
        let matchProduct = [];
        let product = JSON.parse(this.$cookie.get('product'))
        let coupon = JSON.parse(this.$cookie.get('coupon'))
        for (let i = 0; i<coupon.coupon_items.length; i++){
          let match = product.filter(array=>array.foodName == coupon.coupon_items[i].name && array.quantity == coupon.coupon_items[i].quantity)
          if(match.length != 0){
            matchProduct.push(match);
          }
        }
      },
      checkCoupon(coupon){
        if(this.checkLogin()){
          let id = this.$cookie.get('shopId');
          let orderItems = this.$cookie.get('product')

          let data = { coupon_code:coupon,seller_id:id,orderItems:orderItems,total_price:this.totalPrice}
          console.log(data)
//           {
              //     "id":,
              //     "quantity":
              // }
            //           {
            //   "code":,
            //   "seller_id":,
            //   "orderItems":[{}, {}],
            //   "total_price":
            // }
          this.$http.post('/customer/coupon/use',data , {
            headers: {
              'Authorization': 'Bearer ' + this.$store.getters['auth/token']
            }
          })
          .then(response =>{
            this.useValidCoupon()
            this.addCouponToCookie(coupon)
            this.getCouponItems(coupon)
            this.checkItemsInCoupon()
          })
          .catch(error => {
            console.log(error.response)
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
        this.couponState = true;
      },
      modifyCoupon(){
        let coupon_input = document.querySelector('#coupon-input')
        this.couponState = null;
        coupon_input.removeAttribute("readOnly");
        document.cookie = 'couppon=; expires=Thu, 01 Jan 1970 00:00:00 GMT'; 
        document.cookie = 'couponId=; expires=Thu, 01 Jan 1970 00:00:00 GMT'; 
        document.cookie = 'couponName=; expires=Thu, 01 Jan 1970 00:00:00 GMT'; 
      },
      inValidAlert(){
        this.$fire({
            type: 'error',
            title: '無此優惠券',
            confirmButtonText:'確定',
          })
      },
      confirmModal() {
        this.$bus.$emit("cashier",this.dataToCashier());
      },
      modifySpinValue(index,value){
        let productCookie = JSON.parse(this.$cookie.get("product"));
        productCookie[index].quantity = value
        document.cookie = 'product=; expires=Thu, 01 Jan 1970 00:00:00 GMT'; 
        this.$cookie.set('product', JSON.stringify(productCookie))
        this.totalPrice = this.totalPrice + (value - this.ItemList[index].foodSpinValue) * this.ItemList[index].foodPrice
        this.ItemList[index].foodSpinValue = value;
      },
      deleteCartCell(e){
        this.totalPrice = this.totalPrice - this.ItemList[e].foodPrice*this.ItemList[e].foodSpinValue;
        this.ItemList.splice(e,1);
        if(this.totalPrice == 0) {
          this.bookingShopName = null;
          this.totalPrice = null;
          }
        if(this.ItemList.length == 0) //delete cookie
        { 
          document.cookie = 'shopId=; expires=Thu, 01 Jan 1970 00:00:00 GMT'; 
          document.cookie = 'shopName=; expires=Thu, 01 Jan 1970 00:00:00 GMT'; 
          document.cookie = 'product=; expires=Thu, 01 Jan 1970 00:00:00 GMT'; 
        }
        else{ this.$cookie.set('product',JSON.stringify(this.ItemList));}
      },
      onClose() {
        this.popoverShow = false
      },
      onOk() {
          if(this.checkLogin()){
            this.$cookie.set('product',JSON.stringify(this.ItemList));
            this.confirmModal()
            this.onClose()
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
            foodSpinValue: spinValue,    
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