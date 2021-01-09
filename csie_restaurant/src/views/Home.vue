<template>
  <div class="home">
    <Carousel imgPath1="https://picsum.photos/1024/480/?image=54" imgPath2='https://picsum.photos/1024/480/?image=12' imgPath3='https://picsum.photos/1024/480/?image=22'/>
    <center >
      <div class="container row justify-content-center cardMargin">
        <div class="col-10">
          <b-card>
            <div class="row">
              <div class="col-2">
                <Checkbox v-on:selectChange="updateSelected" :categories="categories"/>
              </div>
              <div class="col-10">
                <ShopCardGroup :cards="cards"/>
              </div>
            </div>
          </b-card>
        </div>
      </div>
    </center>
  </div>
</template>

<script>
// @ is an alias to /src
import ShopCardGroup from "@/components/ShopCardGroup.vue";
import Carousel from "@/components/Carousel.vue";
import Checkbox from "@/components/Checkbox.vue";
export default {
  name: "home",
  components: {
    Carousel,
    Checkbox,
    ShopCardGroup
  },
  methods:{
    updateSelected(e) {
      this.selected = e;
    },
    getShops() {
      this.$http.get('/restaurants/?currentNumber=0&requiredNumber=10')
      .then(response => {
        this.loadShops(response.data)
      })
    },
    loadShops(shops) {
      this.cards=[];
      for (let i=0;i<shops.length;i++)
        this.cards.push({shopId: shops[i].seller_id, shopName: shops[i].name, imgPath: this.$url + shops[i].header_image, rating: parseInt(shops[i].averageofratings)});
    }
  },
  data()
  {
    return{
      selected: [],
      cards:[],
      categories:[]
    }
  },
  watch:{
    selected : function(tags) {
        let url='/restaurants/?currentNumber=0&requiredNumber=10';
        for (let i=0;i<tags.length;i++)    url=url+'&filters[]='+tags[i]
        this.$http.get(url)
        .then(response => {
            this.cards=[];
            let data=response.data;
            for (let i=0;i<data.length;i++) this.cards.push({shopId: data[i].seller_id, shopName: data[i].name, imgPath: this.$url + data[i].header_image, rating: parseFloat(data[i].averageofratings)});
        })
    },
  },
  created(){
    let sR = this.$store.getters['auth/searchResult'];
    if(sR.length != 0) {
        console.log('NOTNULL')
        this.cards = [];
        for(let i=0; i<sR.length; i++){
          this.cards.push({shopId: sR[i].seller_id, shopName: sR[i].name, imgPath: this.$url + sR[i].header_image, rating: sR[i].averageofratings});
        } 
    }
    else {
      this.getShops();
    }
    
    this.$http.get('/restaurants/category')
    .then(response => (this.categories = response.data))

    this.$bus.$on('reloadHome',  () =>{
      console.log('Homeon')
      let shops = this.$store.getters['auth/searchResult'];
      this.loadShops(shops)
    });
    this.$bus.$on('resetHome',  () =>{
      console.log('resetHome')
      this.getShops()
    });
  },
  mounted(){
  }
}
</script>

<style scopped>
  .container{
    max-width:100% !important; 
    padding: 0% !important;
    overflow: hidden;
  }
  .cardMargin{
    margin-bottom: 1%;
  }
  .splitLine{
    border-right: thin solid gray;
  }
</style>