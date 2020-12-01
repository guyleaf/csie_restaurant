<template>
  <div class="home">
    <Carousel imgPath1="https://picsum.photos/1024/480/?image=54" imgPath2='https://picsum.photos/1024/480/?image=12' imgPath3='https://picsum.photos/1024/480/?image=22'/>
    <center >
      <div class="container row justify-content-center cardMargin">
        <div class="col-10">
          <b-card>
            <div class="container row">
              <div class="col-3 splitLine">
                <Checkbox v-on:selectChange="updateSelected" />
              </div>
              <div class="col-9">
                <ShopCardGroup :tag="selected"/>
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
    ShopCardGroup,
  },
  methods:{
    updateSelected(e){
      this.selected = e;
    }
  },
  data()
  {
    return{
      selected: []
    }
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