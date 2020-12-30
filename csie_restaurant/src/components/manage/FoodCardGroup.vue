<template>
    <div class="container">
        <CategoryTab :foodCategory="foodCategory" />
        <div class="row" v-for="category in foodCategories" :key="category.categoryId">
            <div class="row">
                <h1>{{category.foodCategory}}</h1>
                <b-button style="margin:15px">ADD PRODUCT</b-button>
            </div>
            <div class="row fback" >
                <FoodCard 
                    v-for="card in sameTag(category.foodCategory)" :key="card.foodId"
                    v-bind="card"
                    :foodName="card.foodName" 
                    :imgPath="card.imgPath" 
                    :foodDescription="card.foodDescription" 
                    :foodTag="card.foodTag"
                />
            </div>
        </div>
    </div>
</template>

<script>
import CategoryTab from "@/components/CategoryTab.vue";
import FoodCard from "@/components/manage/FoodCard.vue";
export default {
    name: "FoodCardGroup",
    components: {
        FoodCard,
        CategoryTab
    },
    props:{
        foodCategory:Array,
        foodToCart: Array,
        // foodCategory1:String,
        // foodCategory2:String,
        // foodCategory3:String
    },
    data()
    {
        return{
            foodCategories:[],
            foodCards:
            [
                {foodId: 0,  foodName: 'ShopRon',  imgPath: 'https://placekitten.com/300/300', foodDescription: '11111111',  foodTag: 'Ron', price:123},
                {foodId: 1,  foodName: 'ShopRon',  imgPath: 'https://placekitten.com/300/300', foodDescription: '878787878', foodTag: 'Ron', price:133},
                {foodId: 2,  foodName: 'ShopPan', imgPath: 'https://placekitten.com/300/300', foodDescription: '3333333',   foodTag: 'Pan', price:13},
                {foodId: 3,  foodName: 'Lee',  imgPath: 'https://placekitten.com/300/300', foodDescription: '0000000',   foodTag: 'Lee', price:23},
                {foodId: 4,  foodName: 'Leeaaa',  imgPath: 'https://placekitten.com/300/300', foodDescription: '11111111',  foodTag: 'Lee', price:12},
                {foodId: 5,  foodName: 'Ron',  imgPath: 'https://placekitten.com/300/300', foodDescription: '878787878', foodTag: 'Ron', price:64},
                {foodId: 6,  foodName: 'Ronaa', imgPath: 'https://placekitten.com/300/300', foodDescription: '7777777',   foodTag: 'Ron', price:17},
                {foodId: 7,  foodName: 'Lee',  imgPath: 'https://placekitten.com/300/300', foodDescription: '0000000',   foodTag: 'Lee', price:283},
                {foodId: 8,  foodName: 'Leeaa',  imgPath: 'https://placekitten.com/300/300', foodDescription: '11111111',  foodTag: 'Lee', price:173},
                {foodId: 9,  foodName: 'ShopPan',  imgPath: 'https://placekitten.com/300/300', foodDescription: '222222222', foodTag: 'Pan', price:19},
                {foodId: 10, foodName: 'ShoPanf', imgPath: 'https://placekitten.com/300/300', foodDescription: '5555555',   foodTag: 'Pan', price:26},
                {foodId: 11, foodName: 'ShPanee',  imgPath: 'https://placekitten.com/300/300', foodDescription: '6666666',   foodTag: 'Pan', price:183},
                {foodId: 12, foodName: 'ShPanon',  imgPath: 'https://placekitten.com/300/300', foodDescription: '77777777',  foodTag: 'Pan', price:188},
                {foodId: 13, foodName: 'SPanPan',  imgPath: 'https://placekitten.com/300/300', foodDescription: '888888888', foodTag: 'Pan', price:120},
                {foodId: 14, foodName: 'ShPanf', imgPath: 'https://placekitten.com/300/300', foodDescription: '9999999',   foodTag: 'Pan', price:73},
            ] , 
        }
    }, 
    methods:{
        sameTag:function(category){
            return this.foodCards.filter(i => i.foodTag === category)
        },
    },
    created(){
        for(let i=0;i<this.foodCategory.length;i++)
            this.foodCategories.push({categoryId: i,foodCategory: this.foodCategory[i]})
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

</style>