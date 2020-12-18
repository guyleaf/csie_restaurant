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
          { foodName:"a1a", foodPrice: 30, foodSpinValue: 1,},
          { foodName:"a2a", foodPrice: 30, foodSpinValue: 1,},
          { foodName:"a3a", foodPrice: 30, foodSpinValue: 1,},
          { foodName:"a4a", foodPrice: 30, foodSpinValue: 1,},
          { foodName:"a5a", foodPrice: 30, foodSpinValue: 1,},
          { foodName:"a6a", foodPrice: 30, foodSpinValue: 1,},
          { foodName:"a7a", foodPrice: 30, foodSpinValue: 1,},
          { foodName:"a8a", foodPrice: 30, foodSpinValue: 1,},
          { foodName:"a9a", foodPrice: 30, foodSpinValue: 1,},
          { foodName:"a10", foodPrice: 30, foodSpinValue: 1,},
          { foodName:"a111111111111", foodPrice: 30, foodSpinValue: 1,},
        ]
      }
  },
  methods:{
    add(name,spinValue,price)
      {
        this.ItemList.push({foodName: name,foodPrice: price,foodSpinValue: spinValue,});
        this.totalPrice += spinValue*price; //failed
      },
  },
  created(){
    this.totalPrice = 0;
    this.$bus.$on("addfunction",msg =>{
        console.log(msg)
        this.add(msg[0],msg[1],msg[2]);
      })
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