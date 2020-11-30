<template>
    <div class='container'>
        <div class='row'>
            <div class='col-md-4'>
                <b-card
                    overlay 
                    title="SHOP"
                    title-tag="h5"
                    :img-src= "imgPath"
                    img-alt="Card Image"
                    img-width="ˇ300"
                    img-height="150"
                    :sub-title="shopName"
                    sub-title-tag="h3"
                    text-variant="white"
                    sub-title-text-variant="white"
                    class="text-center"
                    style= "font-family: Lucida Console, Courier, monospace font-weight: bold;"
                    >
                </b-card>
            </div>
            <div class='col-md-8'>
                <div class='grid-container'>
                    <div class ='grid-item'>商品:{{commodity}}</div>
                    <div class ='grid-item'>粉絲:{{fans}}</div>
                    <div class ='grid-item'>評分{{rate}}</div>
                    <div class ='grid-item'>加入時間:{{joinDate}}</div>
                </div>
                
            </div>
        </div>
    </div>
</template>

<script>
    export default {
    name: 'ShopIntro',
    props:{
        shopName: String,
        imgPath: String,
        commodity: Number,
        fans: Number,
        joinDate: Date,
        rate: Number
        
    }
}
</script>

<style scoped>
.container{
}
.row{
}
.flex{
    display:flex;
    justify-content:center;
    color:#FFFFFF;
    flex-direction: column;
}
h1{
    font-size: 44px;
}
.row{
    margin: 1.5% 0 1.5% 0;
}
.style1{
    width: 100%;
    background-color: #132328 !important
}
.introText{
    padding: 3%;
}
.container{
    max-width: 100%;
    padding: 0%;
    /* padding:0,0,0,0; */
    /* overflow: hidden; */
}
.grid-container {
  display: grid;
  grid-template-columns: 50% 50%;
  color: #492645;
  padding: 10px;
}
.grid-item {
  padding: 5% 0 5% 0 ;
  font-size: 16px;
  text-align: right;
  color: #492645;
}
.col-md-4{
    padding: 0;
}
</style>


