<template>
    <div>
        <b-card :title="shopName"
            :img-src="imgPath"
            img-alt="Image"
            img-top
            tag="article"
            style="max-width: 15rem;"
            class="mb-2"
        >
            <b-card-text>{{shopDescription}}</b-card-text>
            <b-button variant="light">
                <router-link :to="{name: 'Shop'}" class="link">GO TO SHOP</router-link>
            </b-button>
        </b-card>
    </div>
</template>

<script>
export default {
    name: 'ShopCard',
    props:{
        shopTag: String,
        shopName: String,
        imgPath: String,
        shopDescription: String
    }
}
</script>

<style scopped>
    .link{
        color: rgb(93, 30, 210);
        font-weight: bold;
        text-decoration-line: none;
    }
    .link:hover {
        text-decoration-line: none;
    }
</style>