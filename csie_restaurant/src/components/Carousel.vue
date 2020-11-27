<template>
    <div>
    <b-carousel
        id="carousel-no-animation"
        style="text-shadow: 0px 0px 2px #000"
        no-animation
        indicators
        img-width="1024"
        img-height="480"
    >
        <b-carousel-slide
        caption="First slide"
        :img-src="imagePath1"
        ></b-carousel-slide>
        <b-carousel-slide
        caption="Second Slide"
        :img-src="imagePath2"
        ></b-carousel-slide>
        <b-carousel-slide
        caption="Third Slide"
        :img-src="imagePath3"
        ></b-carousel-slide>
    </b-carousel>
    </div>
</template>

<script>
  export default {
    name:"Carousel",
    props:{
        imagePath1: String,
        imagePath2: String,
        imagePath3: String, 
    }
  }
</script>