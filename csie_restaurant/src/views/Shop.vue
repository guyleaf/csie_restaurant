<template>
    <div >
      <ShopIntro imgPath="https://picsum.photos/900/250/?image=3" shopName="鄒承軒的牛郎專賣店" commodity="15" fans="2" joinDate="2000-02-04" rate="4.3(300)"/>
      <FoodCardGroup/>
    </div>
</template>


<script>
// @ is an alias to /src
import ShopIntro from "@/components/ShopIntro.vue";
import FoodCardGroup from "@/components/FoodCardGroup.vue";
export default {
  name: "Shop",
  components: {
    ShopIntro,
    FoodCardGroup
  },
  data: function() {
    return {};
  },
  methods: {}
};
</script>