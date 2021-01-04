<template>
    <div class="container">
        <CategoryTabManage :foodCategory="foodCategory"/>
        <div class="row" v-for="category in foodCategories" :key="category.categoryId">
            <div class="row">
                <h1>{{category.foodCategory}}</h1>
            </div>
            <div class="fback" >
                <div style="padding:1.25em 0 0 1.25em"><h2>上架中</h2> </div>
                <div class="row" >
                    <FoodCard 
                        v-on:state="changeSellingState"
                        v-for="card in sameTag(category.foodCategory,true)" :key="card.foodId"
                        v-bind="card"
                        :foodName="card.foodName" 
                        :imgPath="card.imgPath" 
                        :foodDescription="card.foodDescription" 
                        :foodTag="card.foodTag"
                        :sellingState="card.sellingState"
                    />
<!-- /////////////////////////////////////      -->
                    <div class="col-md-4 card-body">
                        <b-card tag="article" class="addFoodCard">
                            <div class='row'>
                                <b-icon @mouseleave="category.hover=false" v-if="category.hover" icon="plus-circle-fill" font-scale="4" class="addProduct" @click="showModal"/>
                                <b-icon @mouseover="category.hover=true" v-else icon="plus-circle" font-scale="4" class="addProduct"/>
                            </div>  
                        </b-card>
                    </div>
                </div>    
                <div style="padding:1.25em 0 0 1.25em"><h2>下架中</h2> </div>
                <div class="row" >
                    <FoodCard 
                        v-on:state="changeSellingState"
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
        foodCategory:Array,
    },
    data()
    {
        return{

            foodCategories:[],
            foodCards:
            [
                {sellingState:true, foodId: 0,  foodName: 'ShopRon',  imgPath: 'https://placekitten.com/300/300', foodDescription: '11111111',  foodTag: 'Ron', price:123},
                {sellingState:true, foodId: 1,  foodName: 'ShopRon',  imgPath: 'https://placekitten.com/300/300', foodDescription: '878787878', foodTag: 'Ron', price:133},
                {sellingState:true, foodId: 2,  foodName: 'ShopPan', imgPath: 'https://placekitten.com/300/300', foodDescription: '3333333',   foodTag: 'Pan', price:13},
                {sellingState:true, foodId: 3,  foodName: 'Lee',  imgPath: 'https://placekitten.com/300/300', foodDescription: '0000000',   foodTag: 'Lee', price:23},
                {sellingState:true, foodId: 4,  foodName: 'Leeaaa',  imgPath: 'https://placekitten.com/300/300', foodDescription: '11111111',  foodTag: 'Lee', price:12},
                {sellingState:true, foodId: 5,  foodName: 'Ron',  imgPath: 'https://placekitten.com/300/300', foodDescription: '878787878', foodTag: 'Ron', price:64},
                {sellingState:true, foodId: 6,  foodName: 'Ronaa', imgPath: 'https://placekitten.com/300/300', foodDescription: '7777777',   foodTag: 'Ron', price:17},
                {sellingState:true, foodId: 7,  foodName: 'Lee',  imgPath: 'https://placekitten.com/300/300', foodDescription: '0000000',   foodTag: 'Lee', price:283},
                {sellingState:true, foodId: 16,  foodName: 'Leeaa',  imgPath: 'https://placekitten.com/300/300', foodDescription: '11111111',  foodTag: 'Lee', price:173},
                {sellingState:true, foodId: 9,  foodName: 'ShopPan',  imgPath: 'https://placekitten.com/300/300', foodDescription: '222222222', foodTag: 'Pan', price:19},
                {sellingState:true, foodId: 10, foodName: 'ShoPanf', imgPath: 'https://placekitten.com/300/300', foodDescription: '5555555',   foodTag: 'Pan', price:26},
                {sellingState:true, foodId: 11, foodName: 'ShPanee',  imgPath: 'https://placekitten.com/300/300', foodDescription: '6666666',   foodTag: 'Pan', price:183},
                {sellingState:true, foodId: 12, foodName: 'ShPanon',  imgPath: 'https://placekitten.com/300/300', foodDescription: '77777777',  foodTag: 'Pan', price:188},
                {sellingState:true, foodId: 13, foodName: 'SPanPan',  imgPath: 'https://placekitten.com/300/300', foodDescription: '888888888', foodTag: 'Pan', price:120},
                {sellingState:true, foodId: 14, foodName: 'ShPanf', imgPath: 'https://placekitten.com/300/300', foodDescription: '9999999',   foodTag: 'Pan', price:73},
            ], 
        }
    },
    methods:{
        sameTag:function(category,state){
            return this.foodCards.filter(i => i.foodTag === category && i.sellingState === state)
        },
        showModal() {
            this.$refs['my-modal'].show();
        },
        changeSellingState(id){
            var index = this.foodCards.findIndex(i => i.foodId === id)
            this.foodCards[index].sellingState = !this.foodCards[index].sellingState;
        },
        sortOrder:function(a, b){
            return a - b;
        }
    },
    created(){
        this.foodCategory.sort(function(a,b){
            return a.order - b.order;
        });
        for(let i=0;i<this.foodCategory.length;i++)
            this.foodCategories.push({categoryId: i, foodCategory: this.foodCategory[i].tag,hover:false})
        console.log(this.foodCategories)
    }
}
</script>

<style scoped>
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
