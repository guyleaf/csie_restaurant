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
            <b-form-rating v-model="rating" id="rating-inline" class="mb-1" size="sm" no-border readonly show-value inline precision="1"></b-form-rating>
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
        shopDescription: String,
        rating: Number
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
    #rating-inline:focus {
        box-shadow: none;
    }
</style>