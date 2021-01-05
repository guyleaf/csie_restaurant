<template>
        <b-card overlay class='m-2' style="min-width:300px; height:140px">
            <b-card-title>{{code}}</b-card-title>
            <b-card-text v-if="type === 1">
                <a v-for="product in products" :key="product.product_id">
                    {{product.name}}全免</a>
            </b-card-text>
            <b-card-text v-if="type === 2">
                <a v-for="(product, index) in products" :key="product.product_id">
                    {{product.quantity}}{{product.name}}
                    <a v-if="index != products.length-1 ">+</a>  
                </a>{{discount}}%off
            </b-card-text>
            <b-card-text>期限:{{expire}}</b-card-text>
                <!--b-col md='6'>
                    <b-card-img
                    :src="imgPath" 
                    alt="Image"
                    class="rounded-0">
                    </b-card-img>
                </b-col-->
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
        expire: Date,
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