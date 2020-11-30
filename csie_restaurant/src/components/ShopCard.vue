<template>
    <div>
        <b-card :title="shopName"
            :img-src= "imgPath"
            img-alt="Image"
            img-top
            tag="article"
            style="max-width: 20rem;"
            class="mb-2"
        >
            <b-card-text>{{shopDescription}}</b-card-text>

            <b-button href="#" variant="primary">Go somewhere</b-button>
        </b-card>
    </div>
</template>

<script>
export default {
    name: 'ShopCard',
    props:{
        shopName: String,
        imgPath: String,
        shopDescription: String
    }
}
</script>

<style scopped>
    .b_button{
        align-items: center;
    }
</style>