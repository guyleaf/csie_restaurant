<template>
    <b-card border-variant="light" class="">
        <b-card-group deck class="ml-0 mr-0 card-columns">
            <ShopCard v-for="card in cards" :key="card.shopId" 
                      v-bind="card"      
            />
        </b-card-group>
    </b-card>
</template>

<script>
import ShopCard from "@/components/ShopCard.vue";
export default {
    name: "ShopCardGroup",
    props:{
        tag: Array,
    },
    components: {
        ShopCard
    },
    data()
    {
        return{
            cards:
            []
        }
    },
     watch:{
         tag : function() {
             let url=this.$url+'restaurants/?currentNumber=0&requiredNumber=10';
             for (let i=0;i<this.tag.length;i++)    url=url+'&filters[]='+this.tag[i]
             console.log(url);
            this.$axios.get(url)
            .then(response => {
                    this.cards=[];
                    let data=response.data;
                    for (let i=0;i<data.length;i++) this.cards.push({shopId: data[i].seller_id, shopName: data[i].name, imgPath: data[i].header_image});
                })
            }
     },
     created() {
        this.$axios.get(this.$url+'restaurants/?currentNumber=0&requiredNumber=10')
        .then(response => {
          this.cards=[];
          let data=response.data;
          for (let i=0;i<data.length;i++)this.cards.push({shopId: data[i].seller_id, shopName: data[i].name, imgPath: data[i].header_image});
            }
        )
     },
}
</script>

<style scopped>
    .cardHeader{
        text-align:left;    
        border-bottom:1px solid gray ;
        margin:1%
    }
</style>