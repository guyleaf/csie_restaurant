<template>
    <div class="card">
        <div class="cardHeader">
            <h3>{{ tagName }}</h3>
        </div>
        <b-card-group class="container row justify-content-around">
            <ShopCard v-for="card in cards" :key="card.shopId" 
                      v-bind="card"
                      :shopName="card.shopName" 
                      :imgPath="card.imgPath" 
                      :shopDescription="card.shopDescription" 
                      :shopTag="card.shopTag"
                      :tag="tag" 
            />
        </b-card-group>
    </div>
</template>

<script>
import ShopCard from "@/components/ShopCard.vue";
export default {
    name: "CardGroup",
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
            [
                {shopId: 0,shopName: 'ShopRon',imgPath: '',shopDescription: '11111111',shopTag: 'Ron'},
                {shopId: 1,shopName: 'ShopPan',imgPath: '',shopDescription: '878787878',shopTag: 'Pan'},
                {shopId: 2,shopName: 'ShopLeaf',imgPath: '',shopDescription: '7777777',shopTag: 'Leaf'},
                {shopId: 3,shopName: 'ShopLee',imgPath: '',shopDescription: '0000000',shopTag: 'Lee'},
                {shopId: 4,shopName: 'ShopRon',imgPath: '',shopDescription: '11111111',shopTag: 'Ron'},
                {shopId: 5,shopName: 'ShopPan',imgPath: '',shopDescription: '878787878',shopTag: 'Pan'},
                {shopId: 6,shopName: 'ShopLeaf',imgPath: '',shopDescription: '7777777',shopTag: 'Leaf'},
                {shopId: 7,shopName: 'ShopLee',imgPath: '',shopDescription: '0000000',shopTag: 'Lee'},
                {shopId: 8,shopName: 'ShopRon',imgPath: '',shopDescription: '11111111',shopTag: 'Ron'},
                {shopId: 9,shopName: 'ShopPan',imgPath: '',shopDescription: '878787878',shopTag: 'Pan'},
                {shopId: 10,shopName: 'ShopLeaf',imgPath: '',shopDescription: '7777777',shopTag: 'Leaf'},
                {shopId: 11,shopName: 'ShopLee',imgPath: '',shopDescription: '0000000',shopTag: 'Lee'},
                {shopId: 12,shopName: 'ShopRon',imgPath: '',shopDescription: '11111111',shopTag: 'Ron'},
                {shopId: 13,shopName: 'ShopPan',imgPath: '',shopDescription: '878787878',shopTag: 'Pan'},
                {shopId: 14,shopName: 'ShopLeaf',imgPath: '',shopDescription: '7777777',shopTag: 'Leaf'},
                {shopId: 15,shopName: 'ShopLee',imgPath: '',shopDescription: '0000000',shopTag: 'Lee'},
            ]
        }
    },
    computed: {
        tagName: function() 
        {
            if(this.tag[0]==undefined) return "All"
            let Name=this.tag[0]
            for(let i=1;i<this.tag.length;i++)  Name=Name+"+"+this.tag[i]
            return Name
        }
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