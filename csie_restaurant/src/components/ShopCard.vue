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
            <b-button variant="info">
                <router-link :to="{name: 'Shop'}" class="link">GO TO SHOP</router-link>
            </b-button>
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

<style scoped>
    .link{
        color: rgb(93, 30, 210);
        font-weight: bold;
        text-decoration-line: none;
    }
</style>