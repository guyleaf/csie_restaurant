<template>
    <div >
      <ShopIntro imgPath="https://picsum.photos/900/250/?image=3" shopName="鄒承軒的牛郎專賣店" commodity="15" fans="2" joinDate="2000-02-04" rate="4.3(300)"/>
              <div>
      <CategoryTab />
      </div>
      <FoodCardGroup/>
    </div>
</template>


<script>
// @ is an alias to /src
import ShopIntro from "@/components/ShopIntro.vue";
import FoodCardGroup from "@/components/FoodCardGroup.vue";
import CategoryTab from "@/components/CategoryTab.vue";
export default {
  name: "Shop",
  components: {
    ShopIntro,
    FoodCardGroup,
    CategoryTab
  },
  data: function() {
    return {};
  },
  methods: {}
};
</script>