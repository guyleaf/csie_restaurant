<template>
        <b-card overlay class='m-2' style="min-width:300px; height:180px">
            <b-card-title>{{name}}</b-card-title>
            <b-card-text >{{discount}} % off</b-card-text>
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
        name: String,
        discount: Number,
        expire: Date
    },
    computed:{
    },
    methods:{        
    }
}
</script>

<style scoped>
</style>