<template>
        <b-card overlay class='m-2' style="min-width:360px; height:140px">
            <b-card-title>{{code}}</b-card-title>
            <!-- 0 for免運 1for滿XXX折扣 2for套餐組合><-->
            <b-card-text v-if="type === 0">
                <a style="color:red;">免運費</a>
            </b-card-text>
            <b-card-text v-if="type === 1">
                <a>滿{{money}}元</a> <a style="color:red;">{{discount}}%off</a>
            </b-card-text>
            <b-card-text v-if="type === 2">
                <a v-for="(product, index) in products" :key="product.product_id">
                    {{product.quantity}} {{product.name}}
                    <a v-if="index != products.length-1 ">+</a>  
                </a>
                <a style="color:red;">{{discount}}%off</a>
            </b-card-text>
            <b-card-text>期限:{{expire}}</b-card-text>
            <b-card-footer footer-bg-variant="gray" footer-border-variant="white" class="foodCardHeader">
                <b-row class='brow'>
                    <b-button-group class="bgoption">
                        <b-button size='sm' block  class="boption" variant="primary" @click="showModal">修改</b-button>
                        <b-button size='sm' block  v-if="this.sellingState" class="boption" :variant="this.soldOut ? 'secondary' : 'success'" @click="changeStock">售完</b-button>
                        <b-button size='sm' block  class="boption" :variant="this.sellingState ? 'info' : 'success'" @click="changeShelf">{{ this.sellingState ?  '下' : '上'}}架</b-button>
                        <b-button size='sm' block  class="boption" variant="danger"  @click="deleteProduct">刪除</b-button>
                    </b-button-group>
                </b-row>
                <!-- <b-icon icon="list" :id="'target-'+this.foodId" font-scale="1.2"/> -->
            </b-card-footer>
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
        money: Number,
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