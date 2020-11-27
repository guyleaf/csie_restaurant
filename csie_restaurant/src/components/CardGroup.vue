<template>
    <div>
        <b-card-group deck>
            <ShopCard shopName='ShopRon' imgPath='' shopDescription='11111111' />
            <ShopCard shopName='ShopPan' imgPath='' shopDescription='878787878' />
            <ShopCard shopName='ShopLeaf' imgPath='' shopDescription='7777777' />
            <ShopCard shopName='ShopLee' imgPath='' shopDescription='0000000' />
        </b-card-group>
    </div>
</template>

<script>
import ShopCard from "@/components/ShopCard.vue";
export default {
    name: "CardGroup",
    components: {
        ShopCard
    }
}
</script>