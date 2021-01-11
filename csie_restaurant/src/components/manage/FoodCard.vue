<template>
    <div class="col-md-6 card-body" v-b-hover="hoverCard">
        <b-modal id="modal-sm" size="sm" ref="my-modal" hide-header hide-footer hide-header-close>
            <div class="container">
                <input type="file" accept="image/*" @change="previewImage" id="upload">
                <img :src="preview" @click="upload" class="preview"/>
                <div class="m-2">
                    <b-form-group
                    label="Name"
                    label-for="name-input"
                    invalid-feedback="商品名不能為空"
                    :state="nameState">
                    <b-form-input
                        ref="name-input"
                        type="text"
                        v-model="vfoodName"
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
                        v-model="vfoodDescription"
                        :state="descriptionState"   type="text"
                        required>{{ foodDescription }}</b-form-input>
                    </b-form-group>
                    <b-form-group
                    label="Price"
                    label-for="price-input"
                    invalid-feedback="價錢不能為空"
                    
                    :state="priceState">
                    <b-form-input
                        ref="price-input"
                        v-model="vprice"
                        :state="priceState" type="number"
                        required>{{ price }}</b-form-input>
                    </b-form-group>
                    <div class="row m-2" style="justify-content:space-around">
                        <b-button variant="primary" @click="confirmModal" size="sm">MODIFY</b-button>
                        <b-button variant="info" @click="cancelModal" size="sm">CANCEL</b-button>
                    </div>
                </div>
            </div> 
        </b-modal>
        <b-card tag="article" no-body>
            <img :src="noStock" class="soldOut" v-if="this.soldOut" /> 
            <div class='row card-body' v-bind:class="{'outOfStock':this.soldOut}">
                <b-col md='6' >
                    <b-card-title> {{foodName}} </b-card-title>
                    <b-card-text class="ellipsis" >{{foodDescription}}</b-card-text>
                    <b-card-text>${{price}}</b-card-text>
                </b-col>
                <b-col md='6'>
                    <b-card-img
                    :src="imgPath" 
                    alt="Image"
                    class="rounded-0 preview">
                    </b-card-img>
                </b-col>
            </div>
            <b-card-footer footer-bg-variant="gray" footer-border-variant="white" class="foodCardHeader">
                <b-row class='brow'>
                    <b-button-group class="bgoption">
                        <b-button size='sm' block  class="boption" variant="primary" @click="showModal">修改</b-button>
                        <b-button size='sm' block  v-if="this.sellingState" class="boption" :variant="this.soldOut ? 'secondary' : 'success'" @click="changeStock">售完</b-button>
                        <b-button size='sm' block  class="boption" :variant="this.sellingState ? 'info' : 'success'" @click="changeShelf">{{ this.sellingState ?  '下' : '上'}}架</b-button>
                        <b-button size='sm' block  class="boption" variant="danger"  @click="deleteProduct">刪除</b-button>
                    </b-button-group>
                </b-row>
                <!-- <b-icon icon="list" :id="'target-'+this.foodId" font-scale="1.2"/> -->
            </b-card-footer>
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
        vfoodName:'',
        vfoodDescription:'',
        vprice:'',
        preview: require('../../assets/photoupload.png'),
        noStock: require('../../assets/noStock.png'),
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
        soldOut: Boolean,
        sellingState: Number,
        foodId: Number,
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
            }
        },
        hoverCard() {   
            //缺：lack of the responsive action when hover on the card
        },
        showModal() {
            this.preview=this.imgPath
            this.image=this.imgPath
            this.vfoodName=this.foodName
            this.vfoodDescription=this.foodDescription
            this.vprice=this.price
            this.nameState=null,
            this.descriptionState=null,
            this.priceState=null,
            this.$refs['my-modal'].show();
        },
        confirmModal() {
            if(this.vfoodName == '') {this.nameState=false}
            if(this.vprice == '') {this.priceState=false}
            if(this.nameState!=false && this.priceState!=false)
            {
                let isModified = false;
                
                if(this.foodName != this.vfoodName) {isModified=true;}
                if(this.foodDescription != this.vfoodDescription) {isModified=true;}
                if(this.price != this.vprice) {isModified=true;}
                if(this.imgPath != this.image) {isModified=true;}

                if (isModified) {
                    this.$confirm("確定要更改此商品？","","question").then(() => {
                        let formdata = new FormData();
                        formdata.append('id',this.foodId)
                    
                        if(this.foodName != this.vfoodName) {this.foodName = this.vfoodName;formdata.append('name',this.vfoodName);}
                        if(this.foodDescription != this.vfoodDescription) {this.foodDescription = this.vfoodDescription;formdata.append('description',this.vfoodDescription);}
                        if(this.price != this.vprice) {this.price = this.vprice;formdata.append('price',this.vprice);}
                        if(this.imgPath != this.image) {this.imgPath=this.preview;formdata.append('image',this.image);}
                
                        this.$http.post('/seller/products/update',formdata,{
                            headers: {
                            'Authorization': 'Bearer ' + this.$store.getters['auth/token'],
                        }}).then(response => {
                            setTimeout(() => {
                                this.$fire({
                                title: "修改成功",
                                text: "",
                                type: "success",
                                timer: 5000
                            })
                            }, 300)
                            this.$refs['my-modal'].hide();
                        }).catch(error=>{
                            setTimeout(() => {
                                this.$fire({
                                title: "修改失敗",
                                text: "",
                                type: "error",
                                timer: 5000
                            })
                            }, 300)
                            this.$refs['my-modal'].hide();
                            console.log(error.response)
                        })
                    })
                }
                else
                    this.$refs['my-modal'].hide();
            }  
        },
        cancelModal() {
            this.$refs['my-modal'].hide();
        },
        deleteModal() {
            this.$refs['my-modal'].hide();
        },
        changeStock(){
            let msg=''
            if(!this.soldOut)  msg='是否標記為售完？'
            else msg='是否確定已補足庫存？'
            this.$confirm(msg,"","question").then(() => {
            this.$emit("changeStock",this.foodId)
            })  
        },
        changeShelf(){
            let msg=''
            if(!this.sellingState)  msg='你確定要上架？'
            else  msg='你確定要下架？'
            this.$confirm(msg,"","question").then(() => {
            this.$emit("changeState",this.foodId)
        })
        },
        deleteProduct(){
            this.$confirm("你確定要刪除？","","question").then(() => {
            this.$emit("deleteProduct",this.foodId)
        });

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
    created(){
        this.preview=this.imgPath
    }
}
</script>

<style scoped>
.brow{
    margin: 0;
}
#upload{
    display: none;
}
.preview{
    width: 100%;
    height: 200px;
}
.outOfStock{
    background-color: rgb(255,255,255) !important;
    opacity: 0.3;
}
.soldOut{
    position: absolute;
    z-index: 18;
    width: 100%;
    height: 100%;
}
.bgoption{
    padding:0px; 
    width:100%;
}
.boption{
    margin:0;
}
.foodCardHeader{
    padding: 0rem;
    z-index: 19;
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