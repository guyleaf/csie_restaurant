<template>
  <div class="container">
    <b-row class="justify-content-md-center mt-5">
      <b-col col lg="4">
        <div class="desField">
          <div v-for="(item,index) in ItemList" :key="index" >
            <CartCell v-on:deleteclick="deleteCartCell" v-bind="item" :index="index"/>
          </div>
        </div>
      </b-col>
      <b-col col lg="1"></b-col>
      <b-col col lg="3">
        <h1>Total Price</h1>
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
    totalPrice: Number
  },
  data() {
      return {
        ItemList:[

        ]
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
          this.ItemList.push({foodName:data[i].foodName, foodSpinValue:data[i].foodSpinValue, foodPrice:data[i].foodPrice});
        }
      },
      deleteCartCell(e){
        // this.ItemList.splice(e,1);
        this.ItemList.pop();
        console.log(this.ItemList,e);
        // this.$cookie.delete('product');
        this.$cookie.set('product',JSON.stringify(this.ItemList));
        console.log(JSON.parse(this.$cookie.get("product")));
      },
  },
  created(){
    console.log(123123123)
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
.desField{
  overflow-x: visible;
  overflow-y: scroll;
  padding:  1%;
  margin:0% 2% 3% 0;
  border-width: 2px;
  border-color: #000000;
  height: 380px;
}
</style>