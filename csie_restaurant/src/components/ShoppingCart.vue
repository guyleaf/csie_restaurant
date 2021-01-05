<template>
  <div id="my-container">
    <div class="my-3">
      <!-- Our triggering (target) element -->
      <b-button id="popover-reactive-1" ref="button" @click="loadingData()">
        ShoppingCart
      </b-button>
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
        訂購餐廳：{{BookingShopName}}  
      </template>
      <div v-for="(item,index) in ItemList" :key="index" >
        <CartCell v-on:deleteclick="deleteCartCell" @spinClick="modifySpinValue" v-bind="item" :index="index"/>
      </div>
      <!-- <b-button @click="add" variant="outline-info" vertical>+</b-button> -->

      <b-button @click="onOk" variant="outline-info" vertical>結帳</b-button>
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
  import CartCell from "@/components/CartCell.vue";
  export default {
    name:"ShoppingCart",
    components: {
        CartCell
    },
    props: {
      BookingShopName: String
    },
    data() {
      return {
        ItemList:[
          {
            foodName: null,
            foodPrice: null,
            foodSpinValue: null,
          }
        ],
        popoverShow: false
      }
    },
    methods: {
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
      dataToCashier(){
        return this.ItemList;
      },
      confirmModal() {
        this.$bus.$emit("cashier",this.dataToCashier());
      },
      modifySpinValue(index,value){
        this.ItemList[index].foodSpinValue = value;
      },
      deleteCartCell(e){
        this.ItemList.splice(e,1);
        this.$cookie.set('product',JSON.stringify(this.ItemList));
      },
      onClose() {
        this.popoverShow = false
      },
      onOk() {
          this.$cookie.set('product',JSON.stringify(this.ItemList));
          this.confirmModal()
          this.onClose()
          if (this.$router.currentRoute['name'] == "Cashier") window.location.reload();
          else this.$router.push("/cashier");
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