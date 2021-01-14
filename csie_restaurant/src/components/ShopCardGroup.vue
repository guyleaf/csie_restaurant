<template>
    <b-card border-variant="light" class="">
        <b-card-group deck class="ml-0 mr-0 card-columns">
            <ShopCard v-for="card in cards" :key="card.shopId" 
                      v-bind="card"/>
        </b-card-group>
    </b-card>
</template>

<script>
import ShopCard from "@/components/ShopCard.vue";
export default {
    name: "ShopCardGroup",
    props:{
        cards: Array,
    },
    components: {
        ShopCard
    },
    data()
    {
        return{
        }
    },
     watch:{
     },
     methods:{
     },
     created() {
        // this.$http.get('/restaurants/?currentNumber=0&requiredNumber=10')
        // .then(response => {
        //     this.cards=[];
        //     let data=response.data;
        //     for (let i=0;i<data.length;i++)this.cards.push({shopId: data[i].seller_id, shopName: data[i].name, imgPath: this.$url + data[i].header_image, rating: data[i].averageofratings});
        // })
        // // console.log('STORERESULT',this.$store.getters['auth/searchResult'])
        // let sR = this.$store.getters['auth/searchResult'];
        // if(sR != null || sR.length!=0 ){
        // // console.log('NOTNULL')
        // this.cards = [];
        // for(let i=0; i<this.sR.length; i++){
        //     this.cards.push({shopId: sR[i].seller_id, shopName: sR[i].name, imgPath: this.$url + sR[i].header_image, rating: sR[i].averageofratings});
        // }
        // }
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