<template>
    <div class='container style1'>
        <div class='row '>
            <div class='col-md-5 flex'>
                    <h1>渴望享受美食嗎？立即訂餐。</h1>
                    <p>搜尋最愛的餐廳、料理或餐點。</p>
            </div>


            <div class='col-md-7 carouselStyle' style="padding=15 15 15 15">
                <b-carousel
                    id="carousel-fade"
                    style="text-shadow: 0px 0px 2px #000"
                    fade
                    indicators
                    img-width="1024"
                    img-height="480"
                >
                    <b-carousel-slide
                    caption="First slide"
                    :img-src= "imgPath1"
                    ></b-carousel-slide>
                    <b-carousel-slide
                    caption="Second Slide"
                    :img-src= "imgPath2"
                    ></b-carousel-slide>
                    <b-carousel-slide
                    caption="Third Slide"
                    :img-src= "imgPath3"
                    ></b-carousel-slide>
                </b-carousel>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
    name: 'Carousel',
    props:{
        shopName: String,
        imgPath1: String,
        imgPath2: String,
        imgPath3: String,
        shopDescription: String
    }
}
</script>

<style scoped>
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
    margin: 1.5%;
}
.style1{
    width: 100%;
    background-color: #132328 !important
}
.container{
    max-width: 100%;
    padding: 0%;
    /* padding:0,0,0,0; */
    /* overflow: hidden; */
}

</style>


