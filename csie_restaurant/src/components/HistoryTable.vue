<template>
  <div>
    <b-table :items="items" :fields="fields" striped responsive="sm">
      <template #cell(訂單狀態)="row">
        <span v-if="row.item.訂單狀態 == '已下單'" class="text-success">{{ row.item.訂單狀態 }}</span>
        <span v-else-if="row.item.訂單狀態 == '店家已確認'" class="text-info">{{ row.item.訂單狀態 }}</span>
        <span v-else-if="row.item.訂單狀態 == '準備中'" class="text-warning">{{ row.item.訂單狀態 }}</span>
        <span v-else-if="row.item.訂單狀態 == '運送中'" class="text-primary">{{ row.item.訂單狀態 }}</span>
        <span v-else-if="row.item.訂單狀態 == '已取消'" class="text-danger">{{ row.item.訂單狀態 }}</span>
        <span v-else>{{ row.item.訂單狀態 }}</span>
      </template>
      <template #cell(評分)="row">
        <div v-if="!row.item.hideRating" class="star">
            <div class='starXin' v-for="(item,index) in list" :key='index'>
              <div @click="clickStar(index,row)" >
                <img :src="row.item.ratingStar>index?stara:starb" @mouseover="hoverStar(index,row)" @mouseleave="unhoverStar(row)"/>
              </div>
            </div>
        </div>
      </template>
      <template #cell(顯示更多)="row">
        <b-button size="sm" @click="show(row);" class="mr-2 detail">
          {{ row.detailsShowing ?  'Hide' : 'Show'}} Details
        </b-button>
      </template>

      <template #row-details="row">
        <b-card>
          <div class='container row'>
            <div class='col-md-3'>
                  <b-row class="mb-2" v-for= "(data,index) in row.item.datas " :key="index">
                      <b-row class="mr-2">{{ data.product_name }}</b-row>
                      <b-row class="mr-2">* {{ data.quantity }} :</b-row>
                      <b-row v-if="data.discount!=null" v-bind:class="{'line-throughdisplay':data.discount<1}" class="mr-2">{{ data.price*data.quantity }}</b-row>
                      <b-row v-if="data.discount<1" class="mr-2"> {{price(data)}} </b-row>
                      <b-row v-if="data.discount<1 && data.discount!=null" class="mr-2 discount pl-1 pr-1"> {{data.discount*10}}折</b-row>
                  </b-row>
            </div>
            <div class='col-md-3 align-self-end'>
                <b-row class="mb-2 justify-content-end">
                  <b-row>運費：</b-row>
                  <b-row v-bind:class="{'line-throughdisplay':row.item.isShippingCoupon,'mr-2':row.item.isShippingCoupon}">{{ row.item.fee }}</b-row>
                  <b-row v-if='row.item.isShippingCoupon' class="mb-2">0</b-row>
                </b-row>
                <b-row class="mb-2 justify-content-end">
                  <b-row>總金額：{{totals(row.item.datas)}}</b-row>
                </b-row>
            </div>
            <div v-if="!row.item.hideRating" class='col-md-6'>
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
        status: ['已下單','店家已確認','準備中','運送中','已完成','已取消'],
        fields: ['店家', '日期', '訂單狀態', '評分', '顯示更多'],
        items: [
          { 
              id:0,
              seller_id:0,
              ratingStar:0,
              isClicked:false,
              isRated:false,
              readonly:false,
              comment:"請留下您的評論。",
              ratingdisabled:true,
              店家: 'Dickerson', 日期: '2020-11-11 04:12:25',
              運輸時間:'null',地址:'null',訂單狀態:'4',
              fee:0,
              isShippingCoupon:false,
              datas:[
                  {name:123123, price:123, quantity:1,discount:1},
                  {name:456, price:456, quantity:2},
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
      price(data){
        if(data.discount==null) return 'Free'
        else if (isNaN(data.discount)) return data.price * data.quantity
        return Math.round((data.price * data.quantity * data.discount))
                // return Math.round((data.price * data.couponQuantity * data.discount) + (data.price * (data.quantity-data.couponQuantity)))
      },
      totals(datas){
        let total=0;
        for(let i=0;i<datas.length;i++) 
        {
          if (isNaN(datas[i].discount) || datas[i].discount == null)
            total=total+(datas[i].price * datas[i].quantity)
          else
            total=Math.round(total+(datas[i].price * datas[i].quantity * datas[i].discount))
        }
        return total
      },
      clickStar(val,history){
        var index = history.index
        if(!this.items[index].isClicked){
          if(!history.detailsShowing){
            this.show(history)
          }
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
      },
      show(history){
        var datas; 
        this.$http.get('/customer/orders/'+history.item.id, {
          headers: {
            'Authorization': 'Bearer ' + this.$store.getters['auth/token']
          }
        }).then(response => {
          datas=response.data
          history.item.datas=[]
          history.item.coupon_item=[]
          history.item.comment=datas.order.comment
          for(let i=0;i<datas.order_items.length;i++) 
          {
            history.item.datas.push({product_name:datas.order_items[i].product_name, price:parseInt(datas.order_items[i].price), quantity:parseInt(datas.order_items[i].quantity),discount:parseFloat(datas.order.discount)})
          }
          if(datas.order.coupon_type==0) history.item.isShippingCoupon=true;
          else history.item.isShippingCoupon=false;
          history.item.fee=datas.order.fee;
          history.toggleDetails()
        })
      }
    },
    mounted() {
      this.$axios.get(this.$url + '/customer/orders', {
        headers: {
          'Authorization': 'Bearer ' + this.$store.getters['auth/token']
        }
      })
      .then(response => {
          this.items=[];
          let data=response.data;
          for (let i=0;i<data.length;i++)
          {
            let ratingdisabled=false
            let isRated=false
            let readonly=false
            let isClicked=false
            let hideRating = false
            if (data[i].status != 4)
              hideRating = true
            
            if(!hideRating && data[i].stars>0) 
            {
              isClicked=true
              isRated=true
              readonly=true
              ratingdisabled=true
            }
            this.items.push({訂單狀態: this.status[data[i].status],ratingStar: data[i].stars, hideRating: hideRating, 日期: data[i].order_time, seller_id: data[i].seller_id, 店家: data[i].seller_name ,id: data[i].order_id, isRated: isRated, readonly: readonly, ratingdisabled:ratingdisabled, isClicked: isClicked});
          }
      })
      .catch(error => {
        this.$store.dispatch('auth/invalidate')
        this.$router.push('/')
      });
    },
  }
</script>

<style scoped>
  pre{
    margin: 0;
    font-size: 16px;
  }
  .discount{
    background-color: yellow;
    font-weight: bold;
  }
  .line-throughdisplay{
    text-decoration:line-through;
    text-decoration-color:red;
    color: rgba(0,0,0,.4);
  }
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