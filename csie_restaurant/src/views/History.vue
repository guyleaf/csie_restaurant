<template>
  <div class="container">
      <HistoryTable/>
  </div>
</template>

<script>
// @ is an alias to /src
import HistoryTable from "@/components/HistoryTable.vue";
export default {
  name: "History",
  components: {
    HistoryTable
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