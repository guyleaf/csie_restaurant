<template>
    <div>
        <b-card no-body class="over-flow-hidden" style="max-width: 540px; border:none">
            <b-row no-gutters class="align-items-center prbody">
                <b-col md="5">
                    <b-form-spinbutton id="sb-inline" min="1" v-model="quantity" inline step size="sm" style="width:7rem"></b-form-spinbutton>
                </b-col>
                <b-col md="5">
                    <b-card-text class = "card_text">{{foodName}}</b-card-text>
                    <b-card-text class = "card_text">{{totalPrice}}</b-card-text>
                    <!--<b-card-text class = "card_text">{{index}}</b-card-text>-->
                </b-col>
                <b-col md="2" align="right">
                    <b-button @click="deleteitem" variant="outline-danger" vertical>x</b-button>
                </b-col>
            </b-row>
        </b-card>
    </div>
</template>
<script>
export default {
    name: 'CartCell',
    props:{
        foodName: String,
        foodPrice: Number,
        quantity: Number,
        index: Number
    },
    methods: {
        deleteitem(){
            this.$emit("deleteclick",this.index)
        }
    },
    computed: {
        totalPrice: function() {
            return this.foodPrice*this.quantity;
        }
    },
    watch: {
        quantity: function(){
            if(this.quantity >=1 ){
                this.$emit("spinClick",this.index,this.quantity)
            }
        }
    },
}
</script>

<style scoped>
    .prbody{
        padding: 0 0 5px 0;
    }
    .card_text{
        text-align: center;
        margin: 0;
        padding: 0;
    }

</style>
