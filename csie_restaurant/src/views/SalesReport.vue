<template>
  <div>
    <center>
      <div class="container row justify-content-start">
        <div class="col-11">
          <b-card>
            <h3 class="Header">查詢列表</h3>
            <Dropdown />
            <Histogram />
          </b-card>
        </div>
      </div>
    </center>
  </div>
</template>
<script>
import Histogram from "@/components/Histogram.vue";
import Dropdown from "@/components/Dropdown.vue";
export default {
    name:"member",
    components:
    {
       Histogram,
       Dropdown
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
  .Header{
    text-align: left;
    color: black;
    padding-left: 2%;
    border-bottom:1px solid gray ;
  }
</style>