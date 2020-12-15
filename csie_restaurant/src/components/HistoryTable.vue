<template>
  <div>
    <b-table :items="items" :fields="fields" striped responsive="sm">
      <template #cell(評分)="row">
        <div class="star">
            <div class='starXin' v-for="(item,index) in list" :key='index'>
              <div @click="star(index,row)">
                <img :src="row.item.xing>index?stara:starb"/>
              </div>
            </div>
        </div>
      </template>
      <template #cell(顯示更多)="row">
        <b-button size="sm" @click="row.toggleDetails" class="mr-2 detail">
          {{ row.detailsShowing ?  'Hide' : 'Show'}} Details
        </b-button>

        <!-- As `row.showDetails` is one-way, we call the toggleDetails function on @change -->
        <b-form-checkbox v-model="row.detailsShowing" @change="row.toggleDetails">
          Details via check
        </b-form-checkbox>
      </template>

      <template #row-details="row">
        <b-card>
          <div class='container row'>
            <div class='col-md-6'>
                <b-row class="mb-2" v-for= "(data,index) in row.item.datas " :key="index">
                    <b-col  >{{ data.name }}</b-col>
                </b-row>
            </div>
            <div class='col-md-6'>
                <div class='row justify-content-center'>
                  <textarea readonly='readonly' placeholder="幹" class='tA'></textarea>
                  <div :id ="'disabled-wrapper'+row.index" class="d-inline-block sb">
                    <b-button :id="'bt'+row.index" class="te" disabled='disabled'>評價</b-button>
                  </div>
                  <b-tooltip :target="'disabled-wrapper'+row.index">Disabled tooltip</b-tooltip>
                </div>
            </div>
          </div>
        </b-card>
      </template>
    </b-table>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        counter: 0,
        textArea:document.querySelectorAll('.tA'),
        list:[0,1,2,3,4],
        stara:'https://i.imgur.com/S1EjjXA.png',//亮星星
        starb:'https://i.imgur.com/gONraUA.png',//暗星星
        fields: ['店家', '日期', '評分', '顯示更多'],
        items: [
          { 
              xing:0,
              rated:false,
              店家: 'Dickerson', 日期: 'Macdonald',
              datas:[
                  {name:123123},
                  {name:456 },
              ]
          }, 
           { 
              xing:0,
              rated:false,
              店家: 'Dickerson', 日期: 'Macdonald',
              datas:[
                  {name:123123},
                  {name:456 },
              ]
          }, 
        ],
      }
    },
    methods:{
      star(val,history){
        if(this.items[history.index].xing == 0 ){
          if(history.detailsShowing ==false){
            history.toggleDetails()
          }
          this.items[history.index].xing = val+1
          console.log("點選了"+(val+1)+"顆星")
          var submit =  document.getElementById("bt"+history.index.toString())
          submit.disabled=!submit.disabled
          submit.classList.remove('disabled')
        }
        this.items[history.index].xing = val+1
        console.log("點選了"+(val+1)+"顆星")

      },
      rating(history){
        if(this.items[history.index].xing == 0)
        console.log("請幹你娘")
      },
    },
  }
</script>

<style scoped>
  .star{
      width: 1%;
      height: 1%;
      display: flex;
  }
  img{
    width: 25px;
    height: 25px;
  }
  .starXin{
      height: 50%;
      display: flex;
      justify-content: flex-start;
      align-items: center;
      line-height: 20px;
  }
  .row{
    margin: 0;
    padding: 0;
  }
  .sb{
    width:85%;
    height:43px;
    margin-top: 1%;
    border-radius:4px;
  }
  .te{
      width:100%;
      height: 100%;
      background:rgba(67,154,255,1);
      border-radius:4px;
      font-size:15px;
      font-family:PingFangSC-Regular;
      font-weight:400;
      color:rgba(254,254,254,1);
  }
  textarea{
      width:85%;
      resize: none;
      height:120px;
      background:rgba(246,246,246,1);
      border-radius:6px;
      font-size:15px;
      font-family:PingFangSC-Regular;
      font-weight:400;
      color:rgba(153,153,153,1);
      line-height:21px;
  }
</style>