<template>
  <div>
    <b-form-group label="商店種類" label-class="checkboxHeader">
      <div v-for="option in options" :key="option.value" class="checkboxMenuPadding">
        <b-form-checkbox class="checkboxMenu"
          v-model="selected"
          :value="option.value"
          @change="onChange()"
        >
          {{ option.text }}
        </b-form-checkbox>
      </div>
    </b-form-group>
  </div>
</template>

<script>
  export default {
      name:"Checkbox",
    data() {
      return {
        selected: [], // Must be an array reference!
        options: [
          { text: 'Ron', value: 'Ron' },
          { text: 'Pan', value: 'Pan' },
          { text: 'Leaf', value: 'Leaf' },
          { text: 'Lee', value: 'Lee' }
        ]
      }
    },
    methods:
    {
      onChange()
      {
        this.$emit("selectChange",this.selected)
      }
    }
  }
</script>

<style scopped>
  .checkboxHeader{
    text-align: left;
    color: #FFFFFF;
    padding-left: 2%;
    background-color: rgb(96,96,96);
  }
  .checkboxMenu{
    text-align:left;
    border-left: medium solid gray;
    border-bottom: thin solid gray;
    background-color:rgb(233,233,233);
    padding-top:1.5%;
    padding-bottom:1.5%;
  }
  .checkboxMenuPadding{
    padding-top:1%;
    padding-bottom:1%;
  }
</style>