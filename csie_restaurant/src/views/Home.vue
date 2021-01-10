<template>
  <div class="home">
    <Carousel imgPath1="https://picsum.photos/1024/480/?image=54" imgPath2='https://picsum.photos/1024/480/?image=12' imgPath3='https://picsum.photos/1024/480/?image=22'/>
    <center>
      <div class="container row justify-content-center cardMargin">
        <div class="col-10">
          <b-card>
            <div class="row">
              <div class="col-2">
                <Checkbox v-on:selectChange="updateSelected" :categories="categories"/>
              </div>
              <div class="col-10">
                <div class="row searchIndicator" v-if="searchMode">
                  <span style="font-weight:700;color:#ee4d2d;">'{{this.keywords}}'</span>搜尋結果
                </div>
                <div class="row">
                  <ShopCardGroup :cards="cards"/>
                </div>
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
        this.cards.push({shopId: shops[i].seller_id, shopName: shops[i].name, imgPath: this.$url + shops[i].header_image, rating: parseFloat(shops[i].averageofratings)});
    }
  },
  data()
  {
    return{
      selected: [],
      cards:[],
      categories:[],
      searchMode: false,
      keywords: ''
    }
  },
  watch:{
    selected : function(tags) {
        this.searchMode = false;
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
    // let sR = this.$store.getters['auth/searchResult'];
    // if(sR.length != 0) {
    //     this.searchMode = true;
    //     this.keywords = this.$store.getters['auth/keywords'];
    //     console.log('NOTNULL')
    //     this.cards = [];
    //     for(let i=0; i<sR.length; i++){
    //       this.cards.push({shopId: sR[i].seller_id, shopName: sR[i].name, imgPath: this.$url + sR[i].header_image, rating: sR[i].averageofratings});
    //     } 
    // }
    // else {
    //   this.searchMode = false;
    //   this.getShops();
    // }
    //this.searchMode = false;
    this.getShops();
    this.$store.dispatch('auth/cleanSearchResult');
    this.$store.dispatch('auth/cleanKeywords');
    
    this.$http.get('/restaurants/category')
    .then(response => (this.categories = response.data))


    this.$bus.$on('reloadHome',  (keywords) =>{
      console.log('Homeon')
      this.searchMode = true;
      let shops = this.$store.getters['auth/searchResult'];
      this.keywords = this.$store.getters['auth/keywords'];
      this.loadShops(shops)
    });
    this.$bus.$on('resetHome',  () =>{
      console.log('resetHome')
      this.searchMode = false;
      this.keywords = '';
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
  .searchIndicator{
    margin-right: 1rem;
    font-size: 1.2rem;
    padding-bottom: calc(0.125rem + 1px);
    margin-bottom: calc(0.15rem + 1px);
    border-bottom: 1px solid gray;
  }
</style>