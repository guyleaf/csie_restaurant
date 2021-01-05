<template>
    <div class="container">
        <div class='tag mt-5'>優惠卷</div>
        <div class='couponField mb-5' style='display:flex; flex-direction:row; '>
            <CouponCard name='123dasd' discount='100' expire='2000:01:07'/>
            <CouponCard name='123dasd' discount='100' expire='2000:01:07'/>
            <CouponCard name='123dasd' discount='100' expire='2000:01:07'/>
            <CouponCard name='123dasd' discount='100' expire='2000:01:07'/>
            <CouponCard name='123dasd' discount='100' expire='2000:01:07'/>
            <CouponCard name='123dasd' discount='100' expire='2000:01:07'/>
            <CouponCard name='123dasd' discount='100' expire='2000:01:07'/>
            <CouponCard name='123dasd' discount='100' expire='2000:01:07'/>
        </div>
    </div>
</template>

<script>
import CouponCard from "@/components/shop/CouponCard.vue";
export default {
    name: "CouponCardGroup",
    components: {
        CouponCard,
    },
    props:{
    },
    data()
    {
        return{
            foodCategories:[],
            /*foodCards:
            [
                {foodId: 0,  foodName: 'ShopRon',  imgPath: 'https://placekitten.com/300/300', foodDescription: '11111111',  foodTag: 'Ron', price:123},
                {foodId: 1,  foodName: 'ShopRon',  imgPath: 'https://placekitten.com/300/300', foodDescription: '878787878', foodTag: 'Ron', price:133},
                {foodId: 2,  foodName: 'ShopPan', imgPath: 'https://placekitten.com/300/300', foodDescription: '3333333',   foodTag: 'Pan', price:13},
                {foodId: 3,  foodName: 'Lee',  imgPath: 'https://placekitten.com/300/300', foodDescription: '0000000',   foodTag: 'Lee', price:23},
                {foodId: 4,  foodName: 'Leeaaa',  imgPath: 'https://placekitten.com/300/300', foodDescription: '11111111',  foodTag: 'Lee', price:12},
                {foodId: 5,  foodName: 'Ron',  imgPath: 'https://placekitten.com/300/300', foodDescription: '878787878', foodTag: 'Ron', price:64},
                {foodId: 6,  foodName: 'Ronaa', imgPath: 'https://placekitten.com/300/300', foodDescription: '7777777',   foodTag: 'Ron', price:17},
                {foodId: 7,  foodName: 'Lee',  imgPath: 'https://placekitten.com/300/300', foodDescription: '0000000',   foodTag: 'Lee', price:283},
                {foodId: 8,  foodName: 'Leeaa',  imgPath: 'https://placekitten.com/300/300', foodDescription: '11111111',  foodTag: 'Lee', price:173},
                {foodId: 9,  foodName: 'ShopPan',  imgPath: 'https://placekitten.com/300/300', foodDescription: '222222222', foodTag: 'Pan', price:19},
                {foodId: 10, foodName: 'ShoPanf', imgPath: 'https://placekitten.com/300/300', foodDescription: '5555555',   foodTag: 'Pan', price:26},
                {foodId: 11, foodName: 'ShPanee',  imgPath: 'https://placekitten.com/300/300', foodDescription: '6666666',   foodTag: 'Pan', price:183},
                {foodId: 12, foodName: 'ShPanon',  imgPath: 'https://placekitten.com/300/300', foodDescription: '77777777',  foodTag: 'Pan', price:188},
                {foodId: 13, foodName: 'SPanPan',  imgPath: 'https://placekitten.com/300/300', foodDescription: '888888888', foodTag: 'Pan', price:120},
                {foodId: 14, foodName: 'ShPanf', imgPath: 'https://placekitten.com/300/300', foodDescription: '9999999',   foodTag: 'Pan', price:73},
            ] , */
        }
    }, 
    methods:{
    },
    created(){
    }
}
</script>

<style scoped>
.tag{
    color: #d0011b;
    font-size: .675rem;
    font-family: Helvetica Neue,Helvetica,Arial,文泉驛正黑,WenQuanYi Zen Hei,Hiragino Sans GB,儷黑 Pro,LiHei Pro,Heiti TC,微軟正黑體,Microsoft JhengHei UI,Microsoft JhengHei,sans-serif;
    font-weight:bolder;
    margin-bottom: 0;
    background-color: #FFFFFF !important;
    padding:1% 0 0 1%;
}

.couponField{
    overflow-x: scroll;
    overflow-y: hidden;
    padding:  1%;

    border-color: #000000;
    height: 180px;
}
</style>