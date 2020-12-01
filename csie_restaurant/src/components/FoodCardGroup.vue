<template>
    <div class="container">
        <div class="row">
            <div class="row">
                <h1>{{foodCategory1}}</h1>
            </div>
            <div class="row">
                <FoodCard foodName='ShopRon' imgPath='https://placekitten.com/300/300' foodDescription='1111111111111111111' price="123"/>
                <FoodCard foodName='ShopPan' imgPath='https://placekitten.com/300/300' foodDescription='8787878788888888888' price="323"/>
                <FoodCard foodName='ShopLeaf' imgPath='https://placekitten.com/300/300' foodDescription='7771111111111111111111111117777' price="163"/>
                <FoodCard foodName='ShopLee' imgPath='https://placekitten.com/300/300' foodDescription='00000000000000000000000000000' price="183"/>
            </div>
        </div>
        <div class="row">
            <div class="row">
                <h1>{{foodCategory2}}</h1>
            </div>
            <div class="row">
                <FoodCard foodName='ShopRon' imgPath='https://placekitten.com/300/300' foodDescription='1111111111111111111' price="123"/>
                <FoodCard foodName='ShopPan' imgPath='https://placekitten.com/300/300' foodDescription='8787878788888888888' price="323"/>
                <FoodCard foodName='ShopLeaf' imgPath='https://placekitten.com/300/300' foodDescription='7771111111111111111111111117777' price="163"/>
                <FoodCard foodName='ShopLee' imgPath='https://placekitten.com/300/300' foodDescription='00000000000000000000000000000' price="183"/>
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
        foodCategory1:String,
        foodCategory2:String
    }
}
</script>

<style scoped>

.row{
    margin:1% 0 1% 0;   
}

</style>