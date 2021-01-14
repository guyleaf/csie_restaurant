<template>
    <div class="container" >
        <CategoryTab :foodCategory="hasProducts(foodCards)" class="tab"/>
        <div class="row" v-for="category in hasProducts(foodCards)" :key="category.categoryId">
            <div class="row" id="category">
                <h1>{{category.foodCategory}}</h1>
            </div>
            <div class="row fback" >
                <FoodCard 
                    v-for="card in sameTag(category.foodCategory,true)" :key="card.foodId"
                    v-bind="card"
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
            return this.foodCards.filter(i => i.foodTag === category && i.sellingState == state)
        },
        hasProducts:function(foodcard){
            return this.foodCategories.filter(i => foodcard.find(j => i.foodCategory === j.foodTag))
        },
    },
    created(){
        let id = this.$router.currentRoute.params.id
        
        this.$http.get('/restaurants/'+id+'/products')
            .then(response => {
            this.foodCards=[];
            let data=response.data;
            for (let i=0;i<data.length;i++) 
                {
                this.foodCards.push({sellingState:data[i].status, soldOut:data[i].sold_out, foodId: data[i].id, foodName: data[i].name, price:data[i].price, imgPath: this.$url + data[i].image_path, foodDescription: data[i].description, foodTag:data[i].category_name});}
                console.log(this.foodCards)
                this.$bus.$emit('productsNumber',this.foodCards.filter(i => i.sellingState == true).length)  
        })
        this.$http.get('/restaurants/'+id+'/category')
            .then(response => {
            this.foodCategories=[];
            let data=response.data;
            for (let i=0;i<data.length;i++) this.foodCategories.push({foodCategory: data[i].name, order: data[i].display_order});
                console.log(this.foodCategories)
                this.foodCategories.sort(function(a,b){
                return a.order - b.order;
                });
            })
    },
    mounted(){
         function setfbacksize()
        {
          let food = document.querySelector('#shopbody')
          let back = document.querySelectorAll('.fback')
          if(food == null || back.length==0) {
              setTimeout(setfbacksize.bind(this),100)
          }
          else {
          for(let i=0;i<back.length;i++) back[i].style.minWidth= (food.clientWidth).toString() +'px'
          }
        }
        setfbacksize()
    },

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