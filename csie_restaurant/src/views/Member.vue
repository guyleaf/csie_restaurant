<template>
  <div>
    <center>
      <div class="container row justify-content-start">
        <div class="col-11">
          <b-card>
            <h1 class="Header">顧客列表</h1>
            <b-nav-form class="ml-auto row">
                <b-input-group size="sm" class="mr-2">
                  <b-form-input type="search" placeholder="會員編號,名稱,帳號,電話"></b-form-input>
                  <b-input-group-prepend is-text>
                      <b-icon icon="search"></b-icon>
                  </b-input-group-prepend>
                </b-input-group>
                <h4 class="center">全部人數：{{amount}}</h4>
            </b-nav-form>
            <MemberTable v-on:deleteMember="deleteMember"/>
          </b-card>
        </div>
      </div>
    </center>
  </div>
</template>
<script>
import MemberTable from "@/components/MemberTable.vue";
export default {
    name:"Member",
    components:
    {
       MemberTable,
    },
    data(){
      return{
        amount: 0
      }
    },
    methods:{
      deleteMember(){
        this.amount -=1
      }
    },
    created(){
      this.$bus.$on('setNumOfMembers', (nums) => {
        this.amount=nums;
      });
    },
}
</script>

<style scopped>
  .center{
    margin:0;
  }
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
  .ml-auto{
    margin: 1% 0 1% 0;
  }
</style>