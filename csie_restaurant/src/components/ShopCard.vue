<template>
    <div v-if="inArray()">
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
        tag: Array,
        shopTag: String,
        shopName: String,
        imgPath: String,
        shopDescription: String
    },
    methods:
    {
        inArray()
        {
            if(this.tag[0]==undefined)   return true;
            for(let i=0;i<this.tag.length;i++)
                if(this.shopTag == this.tag[i]) return true;
            return false;
        }
    }
}
</script>

<style scopped>
    .link{
        color: rgb(93, 30, 210);
        font-weight: bold;
        text-decoration-line: none;
    }
</style>