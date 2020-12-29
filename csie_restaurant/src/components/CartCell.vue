<template>
    <div>
        <b-card no-body class="over-flow-hidden" style="max-width: 540px;">
            <b-row no-gutters class="align-items-center">
                <b-col md="5" @click="modifySpinValue">
                    <b-form-spinbutton id="sb-inline" v-model="foodSpinValue" inline step size="sm" style="width:7rem"></b-form-spinbutton>
                </b-col>
                <b-col md="5">
                    <b-card-text class = "card_text">{{foodName}}</b-card-text>
                    <b-card-text class = "card_text">{{totalPrice}}</b-card-text>
                    <!--<b-card-text class = "card_text">{{index}}</b-card-text>-->
                </b-col>
                <b-col md="2">
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
        foodSpinValue: Number,
        index: Number
    },
    methods: {
        modifySpinValue(){
            this.$emit("spinClick",this.foodSpinValue)
        },
        deleteitem(){
            this.$emit("deleteclick",this.index)
        }
    },
    computed: {
    totalPrice: function() {
       return this.foodPrice*this.foodSpinValue;
    },
  },
    watch: {
        foodSpinValue: function(){
            console.log(1231434234223)
            this.$emit("spinClick",this.index,this.foodSpinValue)
        }
    },
}
</script>

<style scoped>
    .card_text{
        text-align: center;
        margin: 0;
        padding: 0;
    }

</style>
