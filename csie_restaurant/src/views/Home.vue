<template>
  <div class="home">
    <div>
    <Carousel imagePath1='@/assets/logo.png' imagePath2='@/assets/vuemmerce-logo.png'/>
    </div>
    <center>
      <Search />
      <Checkbox />
      <CardGroup />
    </center>
    <div>
      <ShoppingCart />
    </div>
  </div>
</template>

<script>
// @ is an alias to /src
import Search from "@/components/Search.vue";
import CardGroup from "@/components/CardGroup.vue";
import Carousel from "@/components/Carousel.vue";
import Checkbox from "@/components/Checkbox.vue";
import ShoppingCart from "@/components/ShoppingCart.vue";
export default {
  name: "home",
  components: {
    Search,
    Carousel,
    Checkbox,
    ShoppingCart,
    CardGroup
  }
};
</script>

<style scopped>



</style>