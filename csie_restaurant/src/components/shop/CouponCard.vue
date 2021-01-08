<template>
        <b-card overlay class='m-2' style="min-width:360px; height:140px">
            <b-card-title>{{code}}</b-card-title>
            <!-- 0 for免運 1for滿XXX折扣 2for套餐組合><-->
            <b-card-text v-if="type === 0">
                <a>滿{{limitMoney}}元 </a><a style="color:red;">免運費</a>
            </b-card-text>
            <b-card-text v-if="type === 1">
                <a>滿{{limitMoney}}元 </a><a style="color:red;">{{discount*100}}%off</a>
            </b-card-text>
            <b-card-text v-if="type === 2">
                <a v-for="(product, index) in products" :key="product.product_id">
                    {{product.quantity}} {{product.name}}
                    <a v-if="index != products.length-1 ">+</a>  
                </a>
                <a style="color:red;">{{discount*100}}%off</a>
            </b-card-text>
            <b-card-text>期限:{{expire}}</b-card-text>
        </b-card>
</template>

<script>
export default {
    name: 'CouponCard',
    data() {
      return {
      }
    },
    props:{
        code: String,
        products: Array,
        discount: Number,
        limitMoney: Number,
        expire: String,
        type: Number,
    },
    created:{
    },
    computed:{
    },
    methods:{        
    }
}
</script>

<style scoped>
</style>