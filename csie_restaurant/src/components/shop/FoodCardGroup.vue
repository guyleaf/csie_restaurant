<template>
    <div class="container">
        <CategoryTab :foodCategory="foodCategories" />
        <div class="row" v-for="category in foodCategories" :key="category.categoryId">
            <div class="row">
                <h1>{{category.foodCategory}}</h1>
            </div>
            <div class="row fback" >
                <FoodCard 
                    v-for="card in sameTag(category.foodCategory,1)" :key="card.foodId"
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
import FoodCard from "@/components/shop/FoodCard.vue";
export default {
    name: "FoodCardGroup",
    components: {
        FoodCard,
        CategoryTab
    },
    data()
    {
        return{
            foodCategories:[],
            foodCards:[], 
        }
    }, 
    methods:{
        sameTag:function(category,state){
            return this.foodCards.filter(i => i.foodTag === category && i.sellingState === state)
        },
    },
    created(){
    let id = this.$router.currentRoute.params.id
    this.$http.get('restaurants/'+id+'/products')
        .then(response => {
          this.foodCards=[];
          let data=response.data;
          for (let i=0;i<data.length;i++) this.foodCards.push({sellingState:data[i].status, soldOut:data[i].sold_out, foodId: data[i].id, foodName: data[i].name, price:data[i].price, imgPath: 'https://placekitten.com/300/300', foodDescription: data[i].description, foodTag:data[i].category_name});}
        )
    this.$http.get('/restaurants/'+id+'/category')
        .then(response => {
          this.foodCategories=[];
          let data=response.data;
          for (let i=0;i<data.length;i++) this.foodCategories.push({foodCategory: data[i].name, order: data[i].display_order});}
        )
        this.foodCategory.sort(function(a,b){
            return a.order - b.order;
        });
        for(let i=0;i<this.foodCategory.length;i++)
            this.foodCategories.push({categoryId: i, foodCategory: this.foodCategory[i].tag,hover:false})
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