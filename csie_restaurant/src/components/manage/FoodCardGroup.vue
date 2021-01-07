<template>
    <div class="container">
        <b-modal id="modal-sm" size="sm" ref="my-modal" hide-header hide-footer hide-header-close>
            <div class="container">
                <input type="file" accept="image/*" @change="previewImage" id="upload">
                <img :src="preview" @click="upload" class="preview"/>
                <div class="m-2">
                    <b-form-group
                    label="Name"
                    label-for="name-input"
                    invalid-feedback="name is required" type="text"
                    :state="nameState"
                    >
                    <b-form-input
                        v-model="Name"
                        ref="name-input"
                        :state="nameState"
                        required></b-form-input>
                    </b-form-group>
                    <b-form-group
                    label="Description"
                    label-for="description-input"
                    invalid-feedback="description is required"
                    :state="descriptionState"
                    >
                    <b-form-input
                        v-model="Description"
                        :state="descriptionState"
                        ref="description-input"
                        type="text"
                        required></b-form-input>
                    </b-form-group>
                    <b-form-group
                    label="Price"
                    label-for="price-input"
                    invalid-feedback="price is required"
                    :state="priceState"
                    >
                    <b-form-input
                        v-model="Price"
                        ref="price-input"
                        oninput = "value=value.replace(/[^\d]/g,'')"
                        :state="priceState"
                        required></b-form-input>
                    </b-form-group>
                    <div class="row m-2" style="justify-content:space-around">
                        <b-button variant="primary" @click="confirmModal()" size="sm">ADD</b-button>
                        <b-button variant="info" @click="cancelModal" size="sm">CANCEL</b-button>
                    </div>
                </div>
            </div> 
        </b-modal>
        <CategoryTabManage :foodCategory="foodCategories"/>
        <div class="row" v-for="category in foodCategories" :key="category.categoryId">
            <div class="row">
                <h1>{{category.foodCategory}}</h1>
            </div>
            <div class="fback" >
                <div style="padding:1.25em 0 0 1.25em"><h2>上架中</h2> </div>
                <div class="row" >
                    <FoodCard 
                        v-on="{changeStock:changeStock, changeState:changeSellingState, deleteProduct:deleteProduct}"
                        v-for="card in sameTag(category.foodCategory,true)" :key="card.foodId"
                        v-bind="card"
                        id="foodcard"
                        :foodName="card.foodName" 
                        :imgPath="card.imgPath" 
                        :foodDescription="card.foodDescription" 
                        :foodTag="card.foodTag"
                        :sellingState="card.sellingState"
                    />
<!-- /////////////////////////////////////      -->
                    <div class="col-md-6 card-body">
                        <b-card tag="article" class="addFoodCard">
                            <div class='row'>
                                <b-icon @mouseleave="category.hover=false" v-if="category.hover" icon="plus-circle-fill" font-scale="4" class="addProduct" @click="showModal(category.foodCategory)"/>
                                <b-icon @mouseover="category.hover=true" v-else icon="plus-circle" font-scale="4" class="addProduct"/>
                            </div>  
                        </b-card>
                    </div>
                </div>    
                <div style="padding:1.25em 0 0 1.25em"><h2>下架中</h2> </div>
                <div class="row" >
                    <FoodCard 
                        v-on="{changeState:changeSellingState, deleteProduct:deleteProduct}"
                        v-for="card in sameTag(category.foodCategory,false)" :key="card.foodId"
                        v-bind="card"
                        :foodName="card.foodName" 
                        :imgPath="card.imgPath" 
                        :foodDescription="card.foodDescription" 
                        :foodTag="card.foodTag"
                        :sellingState="card.sellingState"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import CategoryTabManage from "@/components/manage/CategoryTabManage.vue";
import FoodCard from "@/components/manage/FoodCard.vue";
export default {
    name: "FoodCardGroup",
    components: {
        FoodCard,
        CategoryTabManage
    },
    props:{
    },
    data()
    {
        return{
            Price:null,
            Description:null,
            Name:null,
            image:'',
            foodCategory:'',
            nameState:null,
            descriptionState:null,
            priceState:null,
            preview: require('../../assets/photoupload.png'),
            foodCategories:[],
            foodCards:
            [
                {sellingState:true, soldOut:false, foodId: 0,  foodName: 'ShopRon',  imgPath: 'https://placekitten.com/300/300', foodDescription: '11111111',  foodTag: 'Ron', price:123},
                {sellingState:true, soldOut:false, foodId: 1,  foodName: 'ShopRon',  imgPath: 'https://placekitten.com/300/300', foodDescription: '878787878', foodTag: 'Ron', price:133},
                {sellingState:true, soldOut:false, foodId: 2,  foodName: 'ShopPan', imgPath: 'https://placekitten.com/300/300', foodDescription: '3333333',   foodTag: 'Pan', price:13},
                {sellingState:true, soldOut:false, foodId: 3,  foodName: 'Lee',  imgPath: 'https://placekitten.com/300/300', foodDescription: '0000000',   foodTag: 'Lee', price:23},
                {sellingState:true, soldOut:false, foodId: 4,  foodName: 'Leeaaa',  imgPath: 'https://placekitten.com/300/300', foodDescription: '11111111',  foodTag: 'Lee', price:12},
                {sellingState:true, soldOut:false, foodId: 5,  foodName: 'Ron',  imgPath: 'https://placekitten.com/300/300', foodDescription: '878787878', foodTag: 'Ron', price:64},
                {sellingState:true, soldOut:false, foodId: 6,  foodName: 'Ronaa', imgPath: 'https://placekitten.com/300/300', foodDescription: '7777777',   foodTag: 'Ron', price:17},
                {sellingState:true, soldOut:false, foodId: 7,  foodName: 'Lee',  imgPath: 'https://placekitten.com/300/300', foodDescription: '0000000',   foodTag: 'Lee', price:283},
                {sellingState:true, soldOut:false, foodId: 16,  foodName: 'Leeaa',  imgPath: 'https://placekitten.com/300/300', foodDescription: '11111111',  foodTag: 'Lee', price:173},
                {sellingState:true, soldOut:false, foodId: 9,  foodName: 'ShopPan',  imgPath: 'https://placekitten.com/300/300', foodDescription: '222222222', foodTag: 'Pan', price:19},
                {sellingState:true, soldOut:false, foodId: 10, foodName: 'ShoPanf', imgPath: 'https://placekitten.com/300/300', foodDescription: '5555555',   foodTag: 'Pan', price:26},
                {sellingState:true, soldOut:false, foodId: 11, foodName: 'ShPanee',  imgPath: 'https://placekitten.com/300/300', foodDescription: '6666666',   foodTag: 'Pan', price:183},
                {sellingState:true, soldOut:false, foodId: 12, foodName: 'ShPanon',  imgPath: 'https://placekitten.com/300/300', foodDescription: '77777777',  foodTag: 'Pan', price:188},
                {sellingState:true, soldOut:false, foodId: 13, foodName: 'SPanPan',  imgPath: 'https://placekitten.com/300/300', foodDescription: '888888888', foodTag: 'Pan', price:120},
                {sellingState:true, soldOut:false, foodId: 14, foodName: 'ShPanf', imgPath: 'https://placekitten.com/300/300', foodDescription: '9999999',   foodTag: 'Pan', price:73},
            ], 
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
        confirmModal() {
            let formdata = new FormData();
            formdata.append('image',this.image);
            formdata.append('name',this.Name);
            formdata.append('price',this.Price);
            formdata.append('sold_out',false);
            formdata.append('description',this.Description);
            formdata.append('status',1);
            formdata.append('is_deleted',false);
            formdata.append('category_name',this.foodCategory);
            console.log(this.Price,this.Description,this.Name,this.foodCategory,formdata.get('image'))
            let foodCard = [{
                'name': this.Name,
                'price': this.Price,
                'sold_out': false,
                'description': this.Description,
                'status': 1,
                'is_deleted': false,
                'category_name': this.foodCategor,
                'image':formdata.getAll('image')
                }]
            this.$http.post('/seller/products/add',formdata,{
                headers: {
                'Authorization': 'Bearer ' + this.$store.getters['auth/token'],
                }
            })
            .catch(error=>{
                console.log(error.response)
            }
            )
        },
        cancelModal() {
            this.preview= require('../../assets/photoupload.png'),
            this.image=''
            this.Price=null,
            this.Name=null,
            this.Description=null,
            this.$refs['my-modal'].hide();
        },
        deleteModal() {
            this.$refs['my-modal'].hide();
        },
        sameTag:function(category,state){
            return this.foodCards.filter(i => i.foodTag === category && i.sellingState == state)
        },
        showModal(foodCategory) {
            this.foodCategory=foodCategory
            console.log(foodCategory)
            this.$refs['my-modal'].show();
        },
        changeStock(id){
            var index = this.foodCards.findIndex(i => i.foodId === id);
            this.foodCards[index].soldOut = !this.foodCards[index].soldOut 
            let foodCards = {id:id, sold_out:this.foodCards[index].soldOut}
            this.$http.post('/seller/products/update',foodCards,{
                headers: {
                'Authorization': 'Bearer ' + this.$store.getters['auth/token'],
                }
            }).catch(error=>{
                console.log(error.response)
            })
        },
        changeSellingState(id){
            var index = this.foodCards.findIndex(i => i.foodId === id);
            this.foodCards[index].sellingState = !this.foodCards[index].sellingState
            let foodCards = {id:id, status:this.foodCards[index].sellingState}
            this.$http.post('/seller/products/update',foodCards,{
                headers: {
                'Authorization': 'Bearer ' + this.$store.getters['auth/token'],
                }
            }).catch(error=>{
                console.log(error.response)
            })
        },
        deleteProduct(id){
            var index = this.foodCards.findIndex(i => i.foodId === id);
            let foodCards = {id:id}
            this.$http.post('/seller/products/delete',foodCards,{
                headers: {
                'Authorization': 'Bearer ' + this.$store.getters['auth/token'],
                }
            }).catch(error=>{
                console.log(error.response)
            })
            this.foodCards.splice(index,1);
        },
        sortOrder:function(a, b){
            return a - b;
        },
        updateTab:function(msg){
            this.foodCategories=[]
            for(let i=0;i<msg.length;i++){
                this.foodCategories.push({foodCategory: msg[i].foodCategory,order: msg[i].order,hover:false})
            }
            console.log(this.foodCategories)
        }
    },
    created(){
        let id =this.$store.getters['auth/user'].id
        this.$http.get('restaurants/'+id+'/products')
        .then(response => {
            this.foodCards=[];
            let data=response.data;
            for (let i=0;i<data.length;i++) {     
                this.foodCards.push({sellingState:data[i].status, soldOut:data[i].sold_out, foodId: data[i].id, foodName: data[i].name, price:data[i].price, imgPath: 'https://placekitten.com/300/300', foodDescription: data[i].description, foodTag:data[i].category_name});}
           
            this.foodCards = this.foodCards.sort(function (a, b) {
                return a.foodName - b.foodName
                });
            }
        )
        this.$http.get('/restaurants/'+id+'/category')
            .then(response => {
            this.foodCategories=[];
            let data=response.data;
            console.log(data)
            for (let i=0;i<data.length;i++) this.foodCategories.push({foodCategory: data[i].name, order: data[i].display_order, hover:false});}
            )
        this.foodCategories.sort(function(a,b){
            return a.order - b.order;
        });
        this.$bus.$on("updateTab", msg => {
            this.updateTab(msg);
        });

    },
    mounted(){
        function setfbacksize()
        {
          let food = document.querySelector('#shopbody')
          let back = document.querySelectorAll('.fback')
          if(food == null || back==null) {
            setTimeout(setfbacksize.bind(this),100)
          }
          else {
            for(let i=0;i<back.length;i++)
            {
                console.log(food)
                back[i].style.minWidth= (shopbody.clientWidth).toString() +'px'
            }
                
          }
        }
        setfbacksize()
    }
}
</script>

<style scoped>
#upload{
    display: none;
}
.preview{
    width: 100%;
    height: 250px;
}
.row{
    margin:1% 0 1% 0;   
}
.fback{
    background-color:#FFFFFF
    
}
.addFoodCard{
    min-height: 188.36px;
    width: 100%;
    height: 100%;
    border:thin gray dashed;
}
.card-body{
    margin-bottom: 0.5%;
}
.addProduct{
    position: absolute;
    top: calc(50% + -32px);
    left: calc(50% + -32px);
}
</style>
