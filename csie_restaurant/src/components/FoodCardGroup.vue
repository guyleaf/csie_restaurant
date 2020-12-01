<template>
    <div class="container">
        <div class="row" v-for="category in foodCategories" :key="category.categoryId">
            <div class="row">
                <h1>{{category.foodCategory}}</h1>
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
import FoodCard from "@/components/FoodCard.vue";
export default {
    name: "FoodCardGroup",
    components: {
        FoodCard
    },
    props:{
        foodCategory:Array,
        // foodCategory1:String,
        // foodCategory2:String,
        // foodCategory3:String
    },
    data()
    {
        return{
            foodCategories:
            [
                {categoryId: 0,  foodCategory: this.foodCategory[0]},
                {categoryId: 1,  foodCategory: this.foodCategory[1]},
                {categoryId: 2,  foodCategory: this.foodCategory[2]},
            ] ,
            foodCards:
            [
                {foodId: 0,  foodName: 'ShopRon',  imgPath: 'https://placekitten.com/300/300', foodDescription: '11111111',  foodTag: 'Ron', price:'12333'},
                {foodId: 1,  foodName: 'ShopRon',  imgPath: 'https://placekitten.com/300/300', foodDescription: '878787878', foodTag: 'Ron', price:'12333'},
                {foodId: 2,  foodName: 'ShopPan', imgPath: 'https://placekitten.com/300/300', foodDescription: '3333333',   foodTag: 'Pan', price:'12333'},
                {foodId: 3,  foodName: 'Lee',  imgPath: 'https://placekitten.com/300/300', foodDescription: '0000000',   foodTag: 'Lee', price:'12333'},
                {foodId: 4,  foodName: 'Leeaaa',  imgPath: 'https://placekitten.com/300/300', foodDescription: '11111111',  foodTag: 'Lee', price:'12333'},
                {foodId: 5,  foodName: 'Ron',  imgPath: 'https://placekitten.com/300/300', foodDescription: '878787878', foodTag: 'Ron', price:'12333'},
                {foodId: 6,  foodName: 'Ronaa', imgPath: 'https://placekitten.com/300/300', foodDescription: '7777777',   foodTag: 'Ron', price:'12333'},
                {foodId: 7,  foodName: 'Lee',  imgPath: 'https://placekitten.com/300/300', foodDescription: '0000000',   foodTag: 'Lee', price:'12333'},
                {foodId: 8,  foodName: 'Leeaa',  imgPath: 'https://placekitten.com/300/300', foodDescription: '11111111',  foodTag: 'Lee', price:'12333'},
                {foodId: 9,  foodName: 'ShopPan',  imgPath: 'https://placekitten.com/300/300', foodDescription: '222222222', foodTag: 'Pan', price:'12333'},
                {foodId: 10, foodName: 'ShoPanf', imgPath: 'https://placekitten.com/300/300', foodDescription: '5555555',   foodTag: 'Pan', price:'12333'},
                {foodId: 11, foodName: 'ShPanee',  imgPath: 'https://placekitten.com/300/300', foodDescription: '6666666',   foodTag: 'Pan', price:'12333'},
                {foodId: 12, foodName: 'ShPanon',  imgPath: 'https://placekitten.com/300/300', foodDescription: '77777777',  foodTag: 'Pan', price:'12333'},
                {foodId: 13, foodName: 'SPanPan',  imgPath: 'https://placekitten.com/300/300', foodDescription: '888888888', foodTag: 'Pan', price:'12333'},
                {foodId: 14, foodName: 'ShPanf', imgPath: 'https://placekitten.com/300/300', foodDescription: '9999999',   foodTag: 'Pan', price:'12333'},
            ] , 
        }
    }, 
    computed:{

    },
    methods:{
        sameTag:function(category){
            return this.foodCards.filter(i => i.foodTag === category)
        },
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