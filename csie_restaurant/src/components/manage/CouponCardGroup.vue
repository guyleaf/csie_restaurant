<template>
    <div class="container">
        <div style="background-color:white">
            <div class='tag mt-5'>優惠卷</div>
            <div class='couponField mb-5' style='display:flex; flex-direction:row; '>
                <div v-for="coupon in couponCards" :key="coupon['coupon'].id">
                    <CouponCard :code="coupon['coupon'].code" :products="coupon['coupon_items']" :discount="coupon['coupon'].discount*100" 
                    :money="coupon['coupon'].limit_money" :start="coupon['coupon'].start_time" :expire="coupon['coupon'].end_time" :type="coupon['coupon'].type"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import CouponCard from "@/components/manage/CouponCard.vue";
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
            couponCards:[] , 
        }
    }, 
    methods:{
    },
    created(){
        let id =this.$store.getters['auth/user'].id
        this.$http.get('restaurants/' + id + '/coupons' + '?include_expired=1'). //FIXME  ?include_expired=1要移除
        then(response => {
            this.couponCards=response.data;
            console.log('Get啦coupons:',this.couponCards);
        })
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
    height: 280px;
}
</style>