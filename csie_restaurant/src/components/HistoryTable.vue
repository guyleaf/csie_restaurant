<template>
  <div>
    <b-table :items="items" :fields="fields" striped responsive="sm">
      <template #cell(評分)="row">
        <div class="star">
            <div class='starXin' v-for="(item,index) in list" :key='index'>
              <div @click="clickStar(index,row)" >
                <img :src="row.item.ratingStar>index?stara:starb" @mouseover="hoverStar(index,row)" @mouseleave="unhoverStar(row)"/>
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
                  <textarea :id="'text'+row.index" :placeholder="items[row.index].comment" class='tA' :readonly="items[row.index].readonly"/>
                  <div :id ="'disabled-wrapper'+row.index" class="d-inline-block sb">
                    <b-button class="te" :disabled="items[row.index].ratingdisabled" @click="submitRating(row)">評價</b-button>
                  </div>
                  <b-tooltip v-if="!items[row.index].isClicked" :target="'disabled-wrapper'+row.index">請先給予評分。</b-tooltip>
                  <b-tooltip v-if="items[row.index].isRated" :target="'disabled-wrapper'+row.index">已留言</b-tooltip>
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
        stara:'https://i.imgur.com/S1EjjXA.png',//亮星星
        starb:'https://i.imgur.com/gONraUA.png',//暗星星
        fields: ['店家', '日期', '評分', '顯示更多'],
        items: [
          { 
              ratingStar:0,
              isClicked:false,
              isRated:false,
              readonly:false,
              comment:"請留下您的評論。",
              ratingdisabled:'disabled',
              店家: 'Dickerson', 日期: 'Macdonald',
              datas:[
                  {name:123123},
                  {name:456 },
              ]
          }, 
           { 
              ratingStar:0,
              isClicked:false,
              isRated:false,
              readonly:false,
              comment:"請留下您的評論。",
              ratingdisabled:'disabled',
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
      clickStar(val,history){
        var index = history.index
        if(!this.items[index].isClicked){
          if(!history.detailsShowing){
            history.toggleDetails()
          }
          this.items[index].ratingdisabled=!this.items[index].ratingdisabled
        }
        if(!this.items[index].isRated){
          this.items[index].isClicked = true
          this.items[index].ratingStar = val+1
        }
      },
      hoverStar(val,history){
        var index = history.index
        if(!this.items[index].isClicked){
          this.items[index].ratingStar = val+1
        }
      },
      unhoverStar(history){
        var index = history.index
        if(!this.items[index].isClicked){
          this.items[index].ratingStar = 0
        }
      },
      submitRating(history){
        var index = history.index
        var textArea = document.getElementById("text"+index.toString())
        var comment = textArea.value
        this.items[index].isRated = true
        this.items[index].readonly = true
        this.items[index].comment = comment
        this.items[index].ratingdisabled=!this.items[index].ratingdisabled
      }
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