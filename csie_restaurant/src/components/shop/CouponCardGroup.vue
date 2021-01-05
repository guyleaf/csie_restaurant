<template>
    <div class="container">
        <div style="background-color:white">
            <div class='tag mt-5'>優惠卷</div>
            <div class='couponField mb-5' style='display:flex; flex-direction:row; '>
                <div v-for="coupon in Coupons" :key="coupon['coupon'].id">
                    <CouponCard :code="coupon['coupon'].code" :products="coupon['coupon_items']" :discount="coupon['coupon'].discount*100" :expire="coupon['coupon'].end_time" :type="coupon['coupon'].type"/>
                </div>
            </div>
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
            Coupons:
            [
                {"coupon": {"id": 12,"code": "bPhZha","start_time": "2020-10-09 16:00:00","end_time": "2020-10-09 16:00:00","type": 2,"discount": "0.8","limit_money": null},
                "coupon_items": [{"coupon_id": 12,"product_id": 7,"quantity": 1,"name": "蜂蜜鬆餅"}]},
                {"coupon": {"id": 12,"code": "bPhZha","start_time": "2020-10-09 16:00:00","end_time": "2020-10-09 16:00:00","type": 2,"discount": "0.8","limit_money": null},
                "coupon_items": [{"coupon_id": 12,"product_id": 7,"quantity": 1,"name": "蜂蜜鬆餅"}, {"coupon_id": 12,"product_id": 6,"quantity": 1,"name": "蜂蜜紅茶"}]},
                {"coupon": {"id": 12,"code": "bPhZha","start_time": "2020-10-09 16:00:00","end_time": "2020-10-09 16:00:00","type": 2,"discount": "0.8","limit_money": null},
                "coupon_items": [{"coupon_id": 12,"product_id": 7,"quantity": 1,"name": "蜂蜜鬆餅"}]},
                {"coupon": {"id": 12,"code": "bPhZha","start_time": "2020-10-09 16:00:00","end_time": "2020-10-09 16:00:00","type": 2,"discount": "0.8","limit_money": null},
                "coupon_items": [{"coupon_id": 12,"product_id": 7,"quantity": 1,"name": "蜂蜜鬆餅"}]},
                {"coupon": {"id": 12,"code": "bPhZha","start_time": "2020-10-09 16:00:00","end_time": "2020-10-09 16:00:00","type": 2,"discount": "0.8","limit_money": null},
                "coupon_items": [{"coupon_id": 12,"product_id": 7,"quantity": 1,"name": "蜂蜜鬆餅"}]},
                /*{"coupon": {"id": 1,"code": "bPhZha","start_time": "2020-10-09 16:00:00","end_time": "2020-10-09 16:00:00","type": 2,"discount": "0.8","limit_money": null},
                "coupon_items": [{"coupon_id": 12,"product_id": 7,"quantity": 1,"name": "蜂蜜鬆餅"}]},
                {"coupon": {"id": 2,"code": "bPhZha","start_time": "2020-10-09 16:00:00","end_time": "2020-10-09 16:00:00","type": 2,"discount": "0.8","limit_money": null},
                "coupon_items": [{"coupon_id": 12,"product_id": 7,"quantity": 1,"name": "蜂蜜鬆餅"}]},
                {"coupon": {"id": 3,"code": "bPhZha","start_time": "2020-10-09 16:00:00","end_time": "2020-10-09 16:00:00","type": 2,"discount": "0.8","limit_money": null},
                "coupon_items": [{"coupon_id": 12,"product_id": 7,"quantity": 1,"name": "蜂蜜鬆餅"}]},
                {"coupon": {"id": 4,"code": "bPhZha","start_time": "2020-10-09 16:00:00","end_time": "2020-10-09 16:00:00","type": 2,"discount": "0.8","limit_money": null},
                "coupon_items": [{"coupon_id": 12,"product_id": 7,"quantity": 1,"name": "蜂蜜鬆餅"}]},
                {"coupon": {"id": 5,"code": "bPhZha","start_time": "2020-10-09 16:00:00","end_time": "2020-10-09 16:00:00","type": 2,"discount": "0.8","limit_money": null},
                "coupon_items": [{"coupon_id": 12,"product_id": 7,"quantity": 1,"name": "蜂蜜鬆餅"}]},*/
            ] , 
        }
    }, 
    methods:{
    },
    created(){
        //this.$http.get()
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