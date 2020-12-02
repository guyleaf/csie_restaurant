<template>
  <body>
    <div class='container'>
      <div class='introBack'>
        <div class='row justify-content-center'>
          <div class='col-md-8'>
        <ShopIntro imgPath="https://picsum.photos/900/250/?image=3" shopName="鄒承軒的牛郎專賣店" commodity="15" fans="2" joinDate="2000-02-04" rate="4.3(300)"/>
          </div>  
        </div>
      </div>
      <div class='row justify-content-center'>
        <div class='col-md-8'>
           <ShopDescription description='AHAStyle 官方旗艦店
                                        【AHAStyle 官方旗艦店 品牌館全新開張！
                                        AHAStyle 是一個以設計和創意為驅動的年輕品牌，由一群有夢想且充滿熱情的夥伴組成，我們堅持原創設計，探索生活中的小創意，崇尚簡約，秉持對高品質的執著，追求每一個細節，以用戶體驗為出發點，致力於美與實用的結合創造給用戶帶來更多便利和享受的產品。
                                        【常見問題】
                                        ＊出貨時間：平日週(一) ~ 週(五)17:00前和週(六)、週(日)13:00前的訂單當日皆會寄出，一般為下單後24小時內出貨，偶有缺貨狀況也會第一時間告知，若有特定少數休假日時間會於此公告。
                                        ＊客服回覆時間：週(一) ~ 週(五) 9:00~17:00，週(六)、週(日) 10:00~13:00 (除特定假日不固定)，有時訊息量較多可能會較晚才回覆到，請您見諒
                                        ＊退換貨規則：15天內皆可退換貨，退貨會有物流司機與您聯絡收取商品。
                                        ＊若商品有瑕疵狀況可以隨時詢問客服，我們一定會完善幫您做好售後服務，謝謝！
                                        台灣總代理 艾海國際有限公司 AIHAI Tech'/>
              <FoodCardGroup :foodCategory='test'/>
        </div>      
      </div>
    </div>
  </body>
</template>

<script>
// @ is an alias to /src
import ShopIntro from "@/components/ShopIntro.vue";
import FoodCardGroup from "@/components/FoodCardGroup.vue";
import ShopDescription from "@/components/ShopDescription.vue";
export default {
  name: "Shop",
  components: {
    ShopIntro,
    ShopDescription,
    FoodCardGroup,  
  },
  data: function() {
    return {
      test : ['Pan','Lee','Ron']
    };
  },
  methods: {}
};
</script>

<style scoped>
body{
  background-color: #F5F5F5;
}
.introBack{
  max-width: 100% !important;
  background: #132328 !important;
}
</style>