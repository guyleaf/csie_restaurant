<template>
  <div class="container">
    <b-row class="justify-content-md-center mt-5">
      <b-col col lg="4">
        <div class="desField">
        <div class="title" style="border-bottom:1px solid;">
          <h2>親愛的Nelson您好，</h2>
          <h2>以下是您購物車內的商品：</h2>
        </div>
          <div v-for="(item,index) in ItemList" :key="index" style="border-bottom:1px solid; justify-content:center" >
            <CartCell v-on:deleteclick="deleteCartCell" v-bind="item" :index="index"/>
          </div>
        </div>
      </b-col>
      <b-col col lg="1"></b-col>
      <b-col col lg="3">
        <h1>Total Price:</h1>
        <h3>{{totalPrice}}</h3>
        <CashierForm />
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
        totalPrice: 0
      }
  },
  methods:{
      parseCookie(){
        let allCookies = JSON.parse(this.$cookie.get("product"));
        return allCookies
      },
      loadingData(){
        this.ItemList = [];
        let data = this.parseCookie();
        for (var i = 0; i<data.length;i++)
        {
          this.ItemList.push({foodName:data[i].foodName, quantity:data[i].quantity, foodPrice:data[i].foodPrice});
          console.log(this.ItemList[i].foodPrice * this.ItemList[i].quantity)
          this.totalPrice += this.ItemList[i].foodPrice * this.ItemList[i].quantity
        }
      },
      deleteCartCell(e){
        this.ItemList.splice(e,1);
        if(this.ItemList.length == 0) //delete cookie
        { 
          document.cookie = 'shopId=; expires=Thu, 01 Jan 1970 00:00:00 GMT'; 
          document.cookie = 'shopName=; expires=Thu, 01 Jan 1970 00:00:00 GMT'; 
          document.cookie = 'product=; expires=Thu, 01 Jan 1970 00:00:00 GMT'; 
        }
        else{ this.$cookie.set('product',JSON.stringify(this.ItemList));}
      },
  },
  created(){
    this.loadingData()
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
.title{
  text-align: left;
  font-weight: bolder;
},
.desField{
  overflow-x: visible;
  overflow-y: scroll;
  padding:  1%;
  margin:2% 2% 3% 0;
  border-width: 2px;
  border-color: #000000;
  height: 380px;
}
</style>