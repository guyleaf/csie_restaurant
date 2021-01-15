<template>
    <center>
      <div class="container row justify-content-start">
        <div class="col-11">
          <b-card>
            <h3 class="Header">查詢列表</h3>
              <b-form-select v-model="filter" :options="options" />
            <OrderTable />
          </b-card>
        </div>
      </div>
    </center>
</template>

<script>
import OrderTable from "@/components/manage/OrderTable.vue";
export default {
    name:"OrderManage",
    components:
    {
       OrderTable,
    },
    data() {
        return {
            filter: 0,
            options: [
            { value: 0, text: '已下單' },
            { value: 1, text: '店家已確認' },
            { value: 2, text: '準備中' },
            { value: 3, text: '運送中' },
            { value: 4, text: '已完成'},
            { value: 5, text: '已取消'},
            ],
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
  .Header{
    text-align: left;
    color: black;
    padding-left: 2%;
    border-bottom:1px solid gray ;
  }
</style>