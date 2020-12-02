<template>
  <div id="my-container">
    <div class="my-3">
      <!-- Our triggering (target) element -->
      <b-button id="popover-reactive-1" variant="outline-secondary" ref="button">
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
        <CartCell v-on:deleteclick="deleteCartCell" v-bind="item" :index="index"/>
      </div>
      <!-- <b-button @click="add" variant="outline-info" vertical>+</b-button> -->

      <b-button @click="onOk" variant="outline-info" vertical>Ok</b-button>
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
            foodName:"aaa",
            foodPrice: 30,
            foodSpinValue: 1,
          }
        ],
        popoverShow: false
      }
    },
    methods: {
      deleteCartCell(e){
          this.ItemList.splice(e,1);
      },
      onClose() {
        this.popoverShow = false
      },
      onOk() {
          this.onClose()
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
      this.$bus.$on("addfunction",msg =>{
        console.log(msg)
        this.add(msg[0],msg[1],msg[2]);
      })
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
</style>