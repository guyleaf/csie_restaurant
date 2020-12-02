<template>
    <div>
        <b-card no-body class="over-flow-hidden" style="max-width: 540px;">
            <b-row no-gutters class="align-items-center">
                <b-col md="5">
                    <b-form-spinbutton id="sb-inline" v-model="value" inline step size="sm" style="width:7rem"></b-form-spinbutton>
                </b-col>
                <b-col md="5">
                    <b-card-text>{{foodName}}</b-card-text>
                    <b-card-text>{{total}}</b-card-text>
                </b-col>
                <b-col md="2">
                    <b-button @click="deleteitem" variant="outline-info" vertical>-</b-button>
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
        index: Number
    },
    data() {
      return {
        value: 1,
        isDelete: false,
      }
    },
    methods: {
        deleteitem(){
            this.$emit("deleteclick",this.index)
        }
    },
    computed: {
    total: function() {
       return this.foodPrice*this.value;
    },
  },
}
</script>

<style scoped>
</style>
