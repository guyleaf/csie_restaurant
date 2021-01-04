<template>
    <div class="col-md-4 card-body" v-b-hover="hoverCard">
        <b-modal id="modal-sm" size="sm" ref="my-modal" hide-header hide-footer hide-header-close>
            <div class="container">
                <input type="file" accept="image/*" @change="previewImage" id="upload">
                <img :src="preview" @click="upload" class="preview"/>
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
                        :state="priceState" type="text"
                        required></b-form-input>
                    </b-form-group>
                    <div class="row m-2" style="justify-content:space-around">
                        <b-button variant="primary" @click="confirmModal" size="sm">ADD</b-button>
                        <b-button variant="info" @click="cancelModal" size="sm">CANCEL</b-button>
                    </div>
                </div>
            </div> 
        </b-modal>
        <b-card tag="article" no-body>
            <b-card-header header-bg-variant="gray" header-border-variant="white" class="foodCardHeader">
                <b-icon icon="list" :id="'target-'+this.foodId" font-scale="1.2"/>
            </b-card-header>
            <div class='row card-body'>
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
                <b-popover 
                    :target="'target-'+this.foodId" 
                    triggers="hover" 
                    fallback-placement="clockwise" 
                    placement="bottom"
                    custom-class="option"
                    >
                    <template #title>操作選項</template>
                        <b-list-group>
                            <b-list-group-item href="#" variant="primary" @click="showModal">修改商品</b-list-group-item>
                            <b-list-group-item href="#" variant="warning" @click="showModal">售完商品</b-list-group-item>
                            <b-list-group-item href="#" variant="danger"  @click="offShelf">下架商品</b-list-group-item>
                            <b-list-group-item href="#" variant="danger"  @click="showModal">刪除商品</b-list-group-item>
                        </b-list-group>
                </b-popover>
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
        preview: require('../../assets/photoupload.png'),
        image: null,
      }
    },
    props:{
        tag :Array,
        foodName: String,
        imgPath: String,
        foodDescription: String,
        price: Number,
        foodId: Number,
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
        upload(){
            let upload=document.querySelector('#upload')
            upload.click()
        },
        previewImage: function(event) {
        var input = event.target;
        if (input.files) {
            var reader = new FileReader();
            reader.onload = (e) => {
            this.preview = e.target.result;
            }
            this.image=input.files[0];
            reader.readAsDataURL(input.files[0]);
        }
        },
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
                console.log(JSON.parse(this.$cookie.get("product")))
            }
        },
        hoverCard() {   
            //缺：lack of the responsive action when hover on the card
        },
        showModal() {
            this.preview=require('../../assets/photoupload.png'),
            this.$refs['my-modal'].show();
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
            this.$refs['my-modal'].hide();
        },
        cancelModal() {
            this.$refs['my-modal'].hide();
        },
        deleteModal() {
            this.$refs['my-modal'].hide();
        },
        offShelf(){
            this.sellingState = false;
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
    },
    watch: {
        sellingState: function(){
            this.$emit("state",this.foodId)
        }
    },
}
</script>

<style scoped>
#upload{
    display: none;
}
.preview{
    width: 250px;
    height: 250px;
}
.option{
    min-height: auto;
}
.foodCardHeader{
    padding: 0.5rem;
}
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