<template>
    <div class='container'>
        <div class='row'>
            <div class='tag'>關於賣場</div>
        </div>
        <div class='row justify-content-end'>
            <div class='coupon'>

            </div>
            <div class='desField col-md-6' >
               <div class='desStyle'>{{description}}</div>
           </div>
        </div>
    </div>
</template>

<script>
    export default {
    name: 'ShopDescription',
    props:{
        description:String
        
    }
}
</script>

<style scoped>
.container{
    margin: 2% 0 2% 0;
}
.row{
    padding-left: 2%;
    padding-right:2%;
    background-color: #FFFFFF !important;
}
.desField{
    overflow-x: visible;
    overflow-y: scroll;
    padding:  1%;
    margin:0% 2% 3% 0;
    border-width: 2px;
    border-color: #000000;
    height: 250px;
}
.desStyle{
    line-height: 1.625rem;
    font-family: Arial, Helvetica, sans-serif;
    font-size: .675rem;
}
.tag{
    color: #d0011b;
    font-size: .675rem;
    font-family: Helvetica Neue,Helvetica,Arial,文泉驛正黑,WenQuanYi Zen Hei,Hiragino Sans GB,儷黑 Pro,LiHei Pro,Heiti TC,微軟正黑體,Microsoft JhengHei UI,Microsoft JhengHei,sans-serif;
    font-weight:bolder;
    margin-bottom: 0;
    background-color: #FFFFFF !important;
    padding:1% 0 0 1%;
}


</style>


