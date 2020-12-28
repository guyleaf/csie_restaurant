<template>
    <div class="col-md-4 card-body" v-b-hover="hoverCard" @click="showModal">
        <b-modal id="modal-sm" size="sm" ref="my-modal" hide-header hide-footer hide-header-close>
            <div class="container">
                <b-img :src="imgPath" fluid alt="Responsive image"></b-img>
                <div class="m-2">
                    <h3 class="mt-3">{{foodName}} </h3>
                    <p>{{foodDescription}} </p>
                    <h4 mt-3>備註</h4>
                    <b-form-textarea id="textarea" v-model="text" placeholder="Enter something..." rows="3"> </b-form-textarea>
                    <div class="row m-2" style="justify-content:space-around">
                        <b-form-spinbutton id="sb-inline" v-model="spinValue" inline step size="sm" style="width:7rem"></b-form-spinbutton>
                        <p>totalPrice: {{total}}</p>
                        <b-button @click="confirmModal" size="sm">CONFIRM</b-button>
                    </div>
                </div>
            </div> 
        </b-modal>
        <b-card tag="article">
            <div class='row'>
                <b-col md='6' >
                    <b-card-title> {{foodName}} </b-card-title>
                    <b-card-text class="ellipsis" >{{foodDescription}}</b-card-text>
                    <b-card-text>${{price}}</b-card-text>
                </b-col>
                <b-col md='6'>
                    <b-card-img
                    :src="imgPath" 
                    alt="Image"
                    class="rounded-0">
                    </b-card-img>
                </b-col>
            </div>
        </b-card>
    </div>
</template>

<script>
export default {
    name: 'FoodCard',
    data() {
      return {
        spinValue: 1,
        text:''
      }
    },
    props:{
        tag :Array,
        foodName: String,
        imgPath: String,
        foodDescription: String,
        price: Number
    },
    computed:{
        total: function() {
            return this.price*this.spinValue;
        },
        dataToCart: function(){
            return [this.foodName, this.spinValue, this.price];
        }
    },
    methods:{
        parseCookie(){
            // let cookies = document.cookie;
            let cookie;
            let allCookies = document.cookie.split('; ');
            let cookieObj = {};
            
            for (var i=0, l=allCookies.length; i<l; i++){
                cookie = allCookies[i];
                cookie = cookie.split('=');
                cookieObj[cookie[0]] = cookie[1];
            }
            return cookieObj;
        },
        addToCookie(){
            let productNum = this.parseCookie()['productNum'];
            let product = 'product';
            let pinValue = 'pinValue';
            let price = 'price';
            if (productNum!=undefined) productNum = parseInt(productNum, 10) + 1;
            else productNum = 1; 
            product = product + productNum;
            pinValue = pinValue + productNum;
            price = price + productNum;
            document.cookie = 'productNum=' + encodeURIComponent(productNum);
            document.cookie = product + '=' + encodeURIComponent(this.foodName);
            document.cookie = pinValue + '=' + encodeURIComponent(this.spinValue);
            document.cookie = price + '=' + encodeURIComponent(this.price);
            console.log(document.cookie.split('; '));
        },
        hoverCard() {   
            //缺：lack of the responsive action when hover on the card
        },
        showModal() {
            this.$refs['my-modal'].show();
        },
        confirmModal() {
            // document.cookie = 'data=; expires=Thu, 01 Jan 1970 00:00:00 GMT'; //delete cookie
            // document.cookie = 'products=; expires=Thu, 01 Jan 1970 00:00:00 GMT'; //delete cookie
            // document.cookie = 'productNum=; expires=Thu, 01 Jan 1970 00:00:00 GMT'; //delete cookie
            // document.cookie = 'product5=; expires=Thu, 01 Jan 1970 00:00:00 GMT'; //delete cookie
            // document.cookie = 'pinValue5=; expires=Thu, 01 Jan 1970 00:00:00 GMT'; //delete cookie
            // document.cookie = 'price5=; expires=Thu, 01 Jan 1970 00:00:00 GMT'; //delete cookie
            this.addToCookie()
            this.$bus.$emit("addfunction",this.dataToCart);
            //缺：lack of return this.dataToCart to ShoppingCart.vue/CartCell.vue
            this.$refs['my-modal'].hide();
        },
    }
}
</script>

<style scoped>
.card-body{
    margin-bottom: 0.5%;
}
.ellipsis {
    overflow:hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    white-space: normal;
}
</style>