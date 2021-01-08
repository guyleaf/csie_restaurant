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
        tag: Array,
        cards: Array,
    },
    components: {
        ShopCard
    },
    data()
    {
        return{
            // cards:
            // []
        }
    },
     watch:{
        tag : function() {
            let url='/restaurants/?currentNumber=0&requiredNumber=10';
            for (let i=0;i<this.tag.length;i++)    url=url+'&filters[]='+this.tag[i]
            this.$http.get(url)
            .then(response => {
                    this.cards=[];
                    let data=response.data;
                    for (let i=0;i<data.length;i++) this.cards.push({shopId: data[i].seller_id, shopName: data[i].name, imgPath: this.$url + data[i].header_image, rating: data[i].averageofratings});
                })
        },
        // cards: function(){
        //     this.$bus.$on(reloadShop, msg=>{
        //         console.log('onnnn',msg);
        //         this.setShops(msg);
        //     })
        // }
     },
     methods:{
         setShops(msg){
            this.cards = msg;
         }
     },
     created() {
        // this.$http.get('/restaurants/?currentNumber=0&requiredNumber=10')
        // .then(response => {
        //     this.cards=[];
        //     let data=response.data;
        //     for (let i=0;i<data.length;i++)this.cards.push({shopId: data[i].seller_id, shopName: data[i].name, imgPath: this.$url + data[i].header_image, rating: data[i].averageofratings});
        // })
        // console.log('STORERESULT',this.$store.getters['auth/searchResult'])
        // let sR = this.$store.getters['auth/searchResult'];
        // if(sR != null || sR.length!=0 ){
        // console.log('NOTNULL')
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