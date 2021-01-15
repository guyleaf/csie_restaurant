<template>
    <div class="col-md-4 card-body" v-b-hover="hoverCard" @click="showModal">
        <b-modal id="modal-sm" size="sm" ref="create-modal" hide-header hide-footer hide-header-close>
            <div class="container">
                <b-img :src="imgPath" fluid alt="Responsive image"></b-img>
                <div class="m-2">
                    <b-form-group
                    label="Name"
                    label-for="name-input"
                    invalid-feedback="name is required" type="text"
                    :state="nameState">
                    <b-form-input
                        ref="name-input"
                        v-model="vName"
                        :state="nameState"
                        required>{{foodName}}</b-form-input>
                    </b-form-group>
                    <b-form-group
                    label="Description"
                    label-for="description-input"
                    invalid-feedback="description is required"
                    :state="descriptionState">
                    <b-form-input
                        ref="description-input"
                        v-model="vDescription"
                        :state="descriptionState"   type="text"
                        required>kl;ffsdkkfs</b-form-input>
                    </b-form-group>
                    <b-form-group
                    label="price"
                    label-for="price-input"
                    invalid-feedback="price is required"
                    :state="priceState">
                    <b-form-input
                        ref="price-input"
                        v-model="vPrice"
                        :state="priceState" :placeholder="price" type="text"
                        required></b-form-input>
                    </b-form-group>
                    <div class="row m-2" style="justify-content:space-around">
                        <b-button variant="primary" @click="confirmModal" size="sm">ADD</b-button>
                        <b-button variant="info" @click="cancelModal" size="sm">CANCEL</b-button>
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
        nameState:null,
        descriptionState:null,
        priceState:null,
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
            if(this.$cookie.get("product")==null) this.$cookie.set('product', JSON.stringify(this.data))
            else 
            {
                let current = JSON.parse(this.$cookie.get("product"));
                current.push(this.data[0])
                this.$cookie.set('product', JSON.stringify(current));
            }
        },
        hoverCard() {   
            //缺：lack of the responsive action when hover on the card
        },
        showModal() {
            this.$refs['create-modal'].show();
        },
        confirmModal() {
            // this.$cookie.delete('product')
            // document.cookie = 'data=; expires=Thu, 01 Jan 1970 00:00:00 GMT'; //delete cookie
            // document.cookie = 'products=; expires=Thu, 01 Jan 1970 00:00:00 GMT'; //delete cookie
            // document.cookie = 'productNum=; expires=Thu, 01 Jan 1970 00:00:00 GMT'; //delete cookie
            // document.cookie = 'product5=; expires=Thu, 01 Jan 1970 00:00:00 GMT'; //delete cookie
            // document.cookie = 'pinValue5=; expires=Thu, 01 Jan 1970 00:00:00 GMT'; //delete cookie
            // document.cookie = 'price5=; expires=Thu, 01 Jan 1970 00:00:00 GMT'; //delete cookie
            if (!this.checkFormValidity()) {
                return
            }
            this.addToCookie()
            this.$bus.$emit("addfunction",this.dataToCart);
            //缺：lack of return this.dataToCart to ShoppingCart.vue/CartCell.vue
            this.foodName = this.vName;
            this.foodDescription = this.vDescription;
            this.price = this.vPrice;
            this.$refs['create-modal'].hide();
        },
        cancelModal() {
            this.$refs['create-modal'].hide();
        },
        checkFormValidity() {
            const valid1 = this.$refs['name-input'].checkValidity()
            const valid2 = this.$refs['description-input'].checkValidity()
            const valid3 = this.$refs['price-input'].checkValidity()
            this.nameState = valid1
            this.descriptionState = valid2
            this.priceState = valid3
            return valid1 && valid2 && valid3
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