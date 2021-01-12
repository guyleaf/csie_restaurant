<template>
  <body>
    <div class='container'>
      <div class='row justify-content-center'>
        <div class='col-md-8'>
            <ShopDescription v-bind="Info" />
            <CouponCardGroup id="couponTab" />
            <FoodCardGroup />
        </div>
      </div>
    </div>
  </body>
</template>

<script>
// @ is an alias to /src
import FoodCardGroup from '@/components/manage/FoodCardGroup.vue';
import CouponCardGroup from '@/components/manage/CouponCardGroup.vue';
import ShopDescription from '@/components/shop/ShopDescription.vue';
export default {
  name: "ShopManage",
  components: {
    ShopDescription,
    FoodCardGroup,
    CouponCardGroup  
  },
  data: function() {
    return {
      Info:[],
    };
  },
  methods: {},
  created(){
    let id = this.$store.getters['auth/user'].id
    this.$http.get('restaurants/'+id+'/Info')
        .then(response => {
          this.Info=[];
          let data=response.data;
          this.Info.push({description: data.description, joinDate: data.created_at.split(" ",1)[0],shopName: data.name, imgPath:"https://picsum.photos/900/250/?image=3", rate:parseFloat(data.averageOfRatings).toFixed(1), numberOfRatings:parseInt(data.numberOfRatings), fans:parseInt(data.numberOfFans)});        })
  }
};
</script>

<style scoped>
body{
  background-color: #F5F5F5;
}
.introBack{
  max-width: 100% !important;
  background: #132328 !important;
}
</style>