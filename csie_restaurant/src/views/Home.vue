<template>
  <div class="home">
    <Carousel imgPath1="https://picsum.photos/1024/480/?image=54" imgPath2='https://picsum.photos/1024/480/?image=12' imgPath3='https://picsum.photos/1024/480/?image=22'/>
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
@media  (min-width: 1200px) {
  .container{
    max-width:100% !important; 
    padding: 0% !important;
    overflow: hidden;
  }
}

</style>