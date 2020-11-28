<template>
    <div class="col-md-4">
        <b-card :title="foodName" :img-src="imgPath" img-alt="Image" img-right img-height="200px" img-width="200px">
                <div class="col-md-4" >
                    <b-card-text class="ellipsis" >{{foodDescription}}</b-card-text>
                    <b-card-text>${{price}}</b-card-text>
                </div>
        </b-card>
    </div>
</template>

<script>
export default {
    name: 'FoodCard',
    props:{
        foodName: String,
        imgPath: String,
        foodDescription: String,
        price: Number
    }
}
</script>

<style scoped>

.ellipsis {
    overflow:hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    white-space: normal;
}
</style>