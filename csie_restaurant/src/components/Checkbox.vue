<template>
  <div>
    <b-form-group label="商店種類" label-class="checkboxHeader">
    <div class="checkboxMenu row mt-1">
      <b-form-checkbox class="mb-1 checkbox"
        v-model="selected"
        @change="onChange()"
        v-for="option in options"
        :key="option.value"
        :value="option.value"
        button
        button-variant="none"
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
    display: flexbox;
    flex-direction: column !important;
    width: 100%;
  }
  .checkbox > .btn{
    display: block;
    color: black;
    background-color: #EEEEEEEE;
    outline: none !important;
    box-shadow: none !important;
  }
  .checkbox > .btn:hover {
    background-color: #edecec;
    outline: none !important;
    box-shadow: none !important;
  }

  .checkbox > .btn:focus {
    outline: none !important;
    box-shadow: none !important;
  }

  .checkbox > .active,  .checkbox > .active:hover{
    color: white;
    background-color: black;
  }

  .checkboxMenuPadding{
    padding-top:1%;
    padding-bottom:1%;
  }
</style>