<template>
  <div>
    <center>
      <div class="container row justify-content-start">
        <div class="col-11">
          <b-card>
            <h3 class="Header">會員列表</h3>
            <b-nav-form class="ml-auto">
                <b-form-input size="sm" class="mr-sm-2" placeholder="會員編號,名稱,帳號,電話"></b-form-input>
                <b-button size="sm" class="my-2 my-sm-0" type="submit" variant="success">button</b-button> <!--input type="image" src="" /-->
            </b-nav-form>
            <MemberTable />
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
       MemberTable 
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
  .ml-auto{
    margin: 1% 0 1% 0;
  }
</style>