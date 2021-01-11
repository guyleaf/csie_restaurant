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
import ShopIntro from '@/components/shop/ShopIntro.vue';
import FoodCardGroup from '@/components/manage/FoodCardGroup.vue';
import CouponCardGroup from '@/components/manage/CouponCardGroup.vue';
import ShopDescription from '@/components/shop/ShopDescription.vue';
export default {
  name: "ShopManage",
  components: {
    ShopIntro,
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
          for (let i=0;i<data.length;i++)this.Info.push({description: data[i].description, joinDate: data[i].created_at.split(" ",1)[0],shopName: data[i].name, imgPath:"https://picsum.photos/900/250/?image=3"});
            }
        )
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