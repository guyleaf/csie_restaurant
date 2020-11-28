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
      @shown="onShown"
      @hidden="onHidden"
    >
      <template #title>
        <b-button @click="onClose" class="close" aria-label="Close">
          <span class="d-inline-block" aria-hidden="true">&times;</span>
        </b-button>
        訂購餐廳：{{BookingShopName}}  
      </template>
      <CartCell foodName='大麥克' foodPrice="75"/>
      <br>
      <CartCell foodName='大薯' foodPrice="55"/>
      <br>
      <CartCell foodName='可樂(大)' foodPrice="40"/>
      <br>
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
        input1: '',
        input1state: null,
        input2: '',
        input2state: null,
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
      onShown() {
        // Called just after the popover has been shown
        // Transfer focus to the first input
        this.focusRef(this.$refs.input1)
      },
      onHidden() {
        // Called just after the popover has finished hiding
        // Bring focus back to the button
        this.focusRef(this.$refs.button)
      },
     /* focusRef(ref) {
        // Some references may be a component, functional component, or plain element
        // This handles that check before focusing, assuming a `focus()` method exists
        // We do this in a double `$nextTick()` to ensure components have
        // updated & popover positioned first
        this.$nextTick(() => {
          this.$nextTick(() => {
            ;(ref.$el || ref).focus()
          })
        })
      }*/
    }
  }
</script>
<style scoped>
  .wide-popover {
    width:1000px;
    max-height: 500px;
  }
</style>