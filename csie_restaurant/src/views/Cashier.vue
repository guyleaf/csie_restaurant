<template>
  <div class="container" >
    <b-row class="justify-content-md-center mt-5">
      <b-col col lg="4" style="box-shadow: 0 2px 16px 15px rgba(0,0,0,0.08); margin-bottom:2%">
        <div class="desField">
          <div class="title" >
            <h2>親愛的{{this.$store.getters['auth/user'].name}}您好，</h2>
            <h2>以下是您購物車內的商品：</h2>
          </div>
          <div class="products">
            <div v-for="(item,index) in ItemList" :key="index"  >
              <CartCell v-on:deleteclick="deleteCartCell" @spinClick="modifySpinValue" v-bind="item" :index="index"/>
            </div>
          </div>
        </div>
        <div class="payOption"> 
          <CashierForm  v-on="{deleteCoupon:deleteCoupon, useCoupon:useCoupon}"/>
        </div>
      </b-col>

      <b-col col lg="1"></b-col>
      <b-col col lg="4" >
        <div class="orderInfo">
          <div class="sendInfo"> 
            <div class="row restaurant"> 
              <b-icon icon="bag-fill" font-scale="1.5" style="margin:1%"> </b-icon>  
              <p nowrap >訂購餐廳 :</p> 
              <p style="text-decoration:underline; margin-left:1%">{{this.$cookie.get('shopName')}}</p>
            </div>
            <div class="row restaurant"> 
              <b-icon icon="clock-fill" font-scale="1.5" style="margin:1%"> </b-icon>  
              <p >預計在 30 到 40 分鐘內抵達</p>
            </div>
            <div class="row restaurant"> 
              <b-icon icon="geo-alt-fill" font-scale="1.5" style="margin:1%"> </b-icon>  
              <p>碰面地點:地址</p>
            </div>
          </div>
          <div class="priceInfo">
            <div class="beforePrice">
              <div class="row" style="margin:3% -15px 3% -15px">
                <div class='col-md-7'>
                  <span>小計</span>
                </div>
                <div class='col-md-5' style="text-align: end;">
                  ${{beforeMoney}}
                  <span >({{productNum}}份餐點)</span>
                </div>
              </div>
              <div class="row" style="margin:3% -15px 3% -15px">
                <div class='col-md-7'>
                  <span>外送費</span>
                </div>
                <div class='col-md-5' style="text-align: end;">${{shipping}}</div>
              </div>
              <div class="row" style="margin:3% -15px 3% -15px">
                <div class='col-md-7'>
                  <span>折扣</span>
                </div>
                <div class='col-md-5' style="text-align: end;">-${{discountMoney}}</div>
              </div>
            </div>
            <div class="row afterPrice">
              <div class='col-md-7'>
                  <h3>您的總金額</h3>
              </div>
              <div class='col-md-5 tlprice' style="text-align: end;"><h3>${{totalPrice}}</h3></div>
            </div>
            <div class="justify-content-end">
                <b-button class="col-md-12 b-submit" variant="secondary" type="submit" @click="checkAll">一鍵下訂單</b-button>
                <div class="col-md-12 " style="text-align:center; margin-top:2%; padding:0; ">
                  條款： 按一下按鈕送出訂單，即表示您確認已詳閱隱私政策，並且同意 孜宮庭園 的 使用條款
                </div>
              </div>
          </div>
       </div>
      </b-col>
    </b-row>
  </div>
</template>

<script>
// @ is an alias to /src
import CartCell from "@/components/CartCell.vue"
import CashierForm from "@/components/CashierForm.vue"
export default {
  name: "Cashier",
  components: {
    CartCell,
    CashierForm
  },
  props:{
    },
  data() {
    return {
        ItemList:[],
        productNum: 0,
        beforeMoney:0,
        totalPrice: 0,
        discountMoney:0,
        shipping:30,
        shop_id: null,
        coupon_code: '',
        address: '',
        payment_method: 1,
        coupon: null,
        taking_method: null
      }
  },
  methods:{
      parseCookie(){
        let allCookies = JSON.parse(this.$cookie.get("product"));
        return allCookies
      },
      loadingData(){
        this.ItemList = [];
        this.totalPrice = 0
        this.beforeMoney = 0
        let data = this.parseCookie();
        if (data != null)
        {
          for (var i = 0; i<data.length;i++)
          {
            this.ItemList.push({foodName:data[i].foodName, quantity:data[i].quantity, foodPrice:data[i].foodPrice});
            this.productNum += this.ItemList[i].quantity;
            this.beforeMoney += this.ItemList[i].foodPrice * this.ItemList[i].quantity
            this.totalPrice = this.beforeMoney
          }
        }
        else
          this.$router.push('/')

        this.coupon_code = this.$cookie.get("coupon_code");
        this.discountMoney = this.$cookie.get('discount')
        this.shop_id = this.$cookie.get("shopId");
        this.totalPrice -= (this.discountMoney -30)
      },
      modifySpinValue(index,value){
        let productCookie = JSON.parse(this.$cookie.get("product"));
        let difValue = value - this.ItemList[index].quantity ;
        productCookie[index].quantity = value
        document.cookie = 'product=; expires=Thu, 01 Jan 1970 00:00:00 GMT'; 
        this.beforeMoney = this.beforeMoney + (value - this.ItemList[index].quantity) * this.ItemList[index].foodPrice
        this.totalPrice = this.beforeMoney + this.shipping
        this.ItemList[index].quantity = value;
        this.productNum += difValue;
        this.$cookie.set('product', JSON.stringify(productCookie))
      },
      deleteCartCell(e){
        if(this.ItemList.length == 1) //delete cookie
        { 
          this.$confirm("移除這個商品會刪除此筆訂單，您確定嗎？","刪除訂單","warning").then(() => {
            this.ItemList.splice(e,1);
            this.$cookie.delete("product")
            this.$cookie.delete("shopName")
            this.$cookie.delete("shopId")
            this.$alert('已刪除訂單','','success').then(()=>{
              this.$router.push("/")
            })
          })
        }
        else{
          this.productNum -= this.ItemList[e].quantity
          this.beforeMoney -= this.ItemList[e].quantity * this.ItemList[e].foodPrice 
          this.totalPrice = this.beforeMoney + this.shipping
          this.ItemList.splice(e,1);
          this.$cookie.set('product',JSON.stringify(this.ItemList));
        }
      },
      useCoupon(){
        this.discountMoney  = this.$cookie.get('discount') ;
        this.coupon = JSON.parse(this.$cookie.get('coupon'));
        if (this.coupon.coupon.type != 1)
          this.totalPrice = this.beforeMoney - this.discountMoney + this.shipping
        else if (this.coupon.coupon.type == 1)
        {
          if (this.discountMoney >= this.shipping)
          {
            this.discountMoney -= this.shipping
            this.shipping = 0
          }
          else
          {
            this.shipping -= this.discountMoney
          }
          
          this.totalPrice = this.beforeMoney - this.discountMoney + this.shipping
        }
      },
      deleteCoupon(){
        // console.log(this.$cookie.get('discount'))
        this.discountMoney  = this.$cookie.get('discount') ;
        this.totalPrice = this.beforeMoney + this.shipping
      },
      checkAll() {
        this.$bus.$emit('checkAll')
      },
      submit() {
        let order = {coupon_code:this.coupon_code, seller_id:parseInt(this.shop_id), address: this.address, taking_method: this.taking_method, payment_method: this.payment_method, fee: this.shipping}
        let cookie = JSON.parse(this.$cookie.get("product"));
        let coupon_code = JSON.parse(this.$cookie.get("coupon_code"));
        console.log(cookie);
        let order_items = []
        for (let i=0;i<cookie.length;i++)
        {
          order_items.push({product_id: cookie[i].id, quantity: cookie[i].quantity, price: cookie[i].foodPrice})
        }

        let data = {
          order: order,
          order_items: order_items,
          coupon_code: coupon_code
        }
        
        this.$axios.post(this.$url + '/order', data,  {
          headers: {
            'Authorization': 'Bearer ' + this.$store.getters['auth/token']
          }
        }).then(response =>{
          // console.log(response.data)
          this.$cookie.delete("product")
          this.$cookie.delete("shopName")
          this.$cookie.delete("shopId")
          this.$cookie.delete("coupon")
          this.$cookie.delete("coupon_code")
          this.$cookie.delete("discount")
          this.$alert("成功建立訂單", "", "success")
          this.$router.push("/")
        }).catch(error => {
          console.log(error.response)
        })
      }
  },
  mounted(){
  },
  created(){
    this.loadingData()
    this.$bus.$on('sync', (data) => {
      // console.log(data);
      this.coupon_code = data.coupon_code
      this.address = data.address
      this.payment_method = data.payment_method
      this.taking_method = data.taking_method
    });
    this.$bus.$on('submit', () => {
      this.submit();
    });
  },
  computed: {
  }
}
</script>

<style scopped>
.container{
  max-width:100% !important; 
  padding: 0% !important;
  overflow: hidden;
}
.b-submit{
  height: 50px;
}
.title{
  margin-bottom: 2%;
  text-align: left;
  font-weight: bolder;
  border-bottom:2px solid #d2d9d2;
}
.products{
  border-bottom:2px solid #d2d9d2;
}
.payOption{
  padding: 1%;
}
.restaurant{
  text-align: center;
  align-items: center;
  margin: 3% -15px 2% -15px;
}
.restaurant>p{
  font-family: UberMoveText-Regular, sans-serif;
  font-size: 18px;
  margin: 0;
  margin-left: 1%;
}
.beforePrice{
  font-size: 20px;
  border-bottom:2px solid #d2d9d2;
}
.afterPrice{
  margin: 3% -15px 3% -15px;
}
.desField{
  overflow-x: hidden;
  overflow-y: hidden;
  padding: 1%;
  margin:2% 2% 2% 0;
  border-width: 2px;
  border-color: #000000;
}
.orderInfo{
  margin:11px 2% 3% 0;
}
.sendInfo{
  padding: 1%;
  border-bottom:2px solid #d2d9d2;
  margin-bottom: 2%;
}
</style>