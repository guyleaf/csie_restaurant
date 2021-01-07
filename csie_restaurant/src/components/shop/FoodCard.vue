<template>
    <div class="col-md-6 card-body" v-b-hover="hoverCard" @click="showModal">
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
            <img :src="noStock" class="soldOut" v-if="this.soldOut" /> 

            <div class='row' v-bind:class="{'outOfStock':this.soldOut}">
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
        change: false,
        spinValue: 1,
        text:'',
        noStock: require('../../assets/noStock.png'),
      }
    },
    props:{
        tag :Array,
        foodName: String,
        imgPath: String,
        foodDescription: String,
        price: Number,
        soldOut: Boolean,
        sellingState: Boolean
    },
    computed:{
        total: function() {
            return this.price*this.spinValue;
        },
        dataToCart: function(){
            return [this.foodName, this.spinValue, this.price];
        },
        data: function(){
            return [{foodName:this.foodName, foodSpinValue:this.spinValue, foodPrice:this.price}];
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
            if (productNum!=undefined) productNum = parseInt(productNum, 10) + 1;
            else productNum = 1;
            if(this.$cookie.get("product")==null) 
            {   
                this.$cookie.set('shopId',this.$router.currentRoute.params.id)
                this.$cookie.set('shopName',this.$router.currentRoute.params.shopName)
                this.$cookie.set('product', JSON.stringify(this.data))
            }
            else 
            {
                let cartShop = this.$cookie.get('shopName')
                let currentShop = this.$router.currentRoute.params.shopName;
                let cartProduct = JSON.parse(this.$cookie.get("product"));
                if(cartShop === this.$router.currentRoute.params.shopName)
                {
                    this.change = false;
                    let checkIndex = this.checkItemExistCart(cartProduct,this.data[0])
                    if(checkIndex != -1) cartProduct[checkIndex].foodSpinValue += this.data[0].foodSpinValue;
                    else cartProduct.push(this.data[0])
                    this.$cookie.set('product', JSON.stringify(cartProduct));
                }
                else
                {
                    this.change = true;
                    this.changeShop(cartShop,currentShop);
                }
            }
        },
        checkItemExistCart(cart,item){
            let index = -1;
            var filteredObj = cart.find(function(cart, i){
                if(cart.foodName === item.foodName){
                    index = i;
                }
            });
            return index;
        },
        changeShop(cartShop,currentShop){
            this.$confirm("您的訂單含有"+' '+cartShop+' '+"提供的餐點。建立新訂單，即可新增"+' '+currentShop+' '+"提供的餐點。","","warning").then(() => {
                this.cleanShopCart()
                this.$cookie.set('shopId',this.$router.currentRoute.params.id)
                this.$cookie.set('shopName',this.$router.currentRoute.params.shopName)
                this.$cookie.set('product', JSON.stringify(this.data))
                // uploadtodatabase
                this.$alert("成功更改","","success");
                this.$bus.$emit("addfunction",this.dataToCart);
                this.$refs['my-modal'].hide();
            })
        },
        cleanShopCart(){
            document.cookie = 'shopId=; expires=Thu, 01 Jan 1970 00:00:00 GMT'; 
            document.cookie = 'shopName=; expires=Thu, 01 Jan 1970 00:00:00 GMT'; 
            document.cookie = 'product=; expires=Thu, 01 Jan 1970 00:00:00 GMT'; 
        },
        hoverCard() {   
            //缺：lack of the responsive action when hover on the card
        },
        showModal() {
            this.$refs['my-modal'].show();
        },
        confirmModal() {
            this.addToCookie()
            if(!this.change){
                this.$bus.$emit("addfunction",this.dataToCart);
                this.$refs['my-modal'].hide();
            }
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
.outOfStock{
    background-color: rgb(255,255,255) !important;
    opacity: 0.3;
}
.soldOut{
    position: absolute;
    z-index: 100;
    width: 100%;
    height: 100%;
}
</style>