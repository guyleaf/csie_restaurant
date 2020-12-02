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
      triggers="focus"
      :show.sync="popoverShow"
      placement="auto"
      container="my-container"
      ref="popover"
      @show="onShow"
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
        options: [{ text: '- Choose 1 -', value: '' }, 'Red', 'Green', 'Blue'],
        input1Return: '',
        input2Return: '',
        popoverShow: false
      }
    },
    watch: {
      input1(val) {
        if (val) {
          this.input1state = true
        }
      },
      input2(val) {
        if (val) {
          this.input2state = true
        }
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
        if (!this.input1) {
          this.input1state = false
        }
        if (!this.input2) {
          this.input2state = false
        }
        if (this.input1 && this.input2) {
          this.onClose()
          // Return our popover form results
          this.input1Return = this.input1
          this.input2Return = this.input2
        }
      },
      onShow() {
        // This is called just before the popover is shown
        // Reset our popover form variables
        this.input1 = ''
        this.input2 = ''
        this.input1state = null
        this.input2state = null
        this.input1Return = ''
        this.input2Return = ''
      },
      add(name,spinValue,price)
      {
        console.log(name);
        console.log(spinValue);
        console.log(price);
        this.ItemList.push(
        {
            foodName: name,
            foodPrice: price,
            foodSpinValue: spinValue,    
        })
      },
    },
    created(){
      this.$bus.$on("addfunction",msg =>{
        console.log(msg)
        this.add(msg[0],msg[1],msg[2]);
      })
    }
  }
</script>
<style scoped>
  .wide-popover {
    width:1000px;
    max-height: 500px;
  }
</style>