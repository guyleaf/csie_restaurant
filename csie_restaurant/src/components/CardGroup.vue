<template>
    <div class="card">
        <div class="cardHeader">
            <h3>Orange</h3>
        </div>
        <b-card-group class="container row justify-content-around">
            <ShopCard v-for="card in cards" :key="card.shopId" :shopName="card.shopName" :imgPath="card.imgPath" :shopDescription="card.shopDescription"/>
        </b-card-group>
    </div>
</template>

<script>
import ShopCard from "@/components/ShopCard.vue";
export default {
    name: "CardGroup",
    components: {
        ShopCard
    },
    data()
    {
        return{
            cards:
            [
                {shopId: 0,shopName: 'ShopRon',imgPath: '',shopDescription: '11111111'},
                {shopId: 1,shopName: 'ShopPan',imgPath: '',shopDescription: '878787878' },
                {shopId: 2,shopName: 'ShopLeaf',imgPath: '',shopDescription: '7777777' },
                {shopId: 3,shopName: 'ShopLee',imgPath: '',shopDescription: '0000000'},
                {shopId: 4,shopName: 'ShopRon',imgPath: '',shopDescription: '11111111'},
                {shopId: 5,shopName: 'ShopPan',imgPath: '',shopDescription: '878787878' },
                {shopId: 6,shopName: 'ShopLeaf',imgPath: '',shopDescription: '7777777' },
                {shopId: 7,shopName: 'ShopLee',imgPath: '',shopDescription: '0000000'},
                {shopId: 8,shopName: 'ShopRon',imgPath: '',shopDescription: '11111111'},
                {shopId: 9,shopName: 'ShopPan',imgPath: '',shopDescription: '878787878' },
                {shopId: 10,shopName: 'ShopLeaf',imgPath: '',shopDescription: '7777777' },
                {shopId: 11,shopName: 'ShopLee',imgPath: '',shopDescription: '0000000'},
                {shopId: 12,shopName: 'ShopRon',imgPath: '',shopDescription: '11111111'},
                {shopId: 13,shopName: 'ShopPan',imgPath: '',shopDescription: '878787878' },
                {shopId: 14,shopName: 'ShopLeaf',imgPath: '',shopDescription: '7777777' },
                {shopId: 15,shopName: 'ShopLee',imgPath: '',shopDescription: '0000000'},
            ]
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