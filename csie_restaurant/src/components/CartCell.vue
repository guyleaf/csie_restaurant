<template>
    <div>
        <b-card no-body class="over-flow-hidden" style="max-width: 540px;">
            <b-row no-gutters>
                <b-col md="6">
                    <b-form-spinbutton id="sb-inline" v-model="spinValue" inline step size="sm" style="width:7rem"></b-form-spinbutton>
                </b-col>
                <b-col md="6">
                    <b-card-text>{{foodName}}</b-card-text>
                    <b-card-text>{{total}}</b-card-text>
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
        price: Number,
    },
    data() {
      return {
        spinValue: 1
      }
    },
    computed: {
    total: function() {
       return this.price*this.spinValue;
    }
  },

}
</script>

<style scoped>
</style>
