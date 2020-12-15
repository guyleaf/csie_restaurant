<template>
  <div>
    <b-table :items="items" :fields="fields" striped responsive="sm">
      <template #cell(評分)>
        <div class="star">
            <div class='starXin' v-for="(item,index) in list" :key='index'>
              <div @click="star(index)">
                <img :src="xing>index?stara:starb"/>
              </div>
            </div>
        </div>
      </template>
      <template #cell(顯示更多)="row">
        <b-button size="sm" @click="row.toggleDetails" class="mr-2">
          {{ row.detailsShowing ?   'Hide' : 'Show'}} Details
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
                <textarea placeholder="幹"></textarea>
                 <button class="te">評價</button>
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
        list:[0,1,2,3,4],
        stara:'https://picsum.photos/1024/480/?image=12',//亮星星
        starb:'https://picsum.photos/1024/480/?image=54',//暗星星
        xing:0,
        fields: ['店家', '日期', '評分', '顯示更多'],
        items: [
          { 
              店家: 'Dickerson', 日期: 'Macdonald',
              datas:[
                  {name:123123},
                  {name:456 }
              ]
          }, 
        ]
      }
    },
    methods:{
      star(val){
          this.xing = val+1
          console.log("點選了"+(val+1)+"顆星")
      }
    }
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
  .te{
      margin-top: 1%;
      width:85%;
      height:43px;
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