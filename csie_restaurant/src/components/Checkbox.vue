<template>
  <div>
    <b-form-group label="商店種類" label-class="checkboxHeader">
    <div class="checkboxMenu row mt-1">
      <b-form-checkbox class="mb-1 checkbox"
        v-model="selected"
        @change="onChange()"
        v-for="category in categories"
        :key="category.category_id"
        :value="category.name"
        button
        button-variant="none"
      >
        {{ category.name }}
      </b-form-checkbox>
    </div>
    </b-form-group>
  </div>
</template>

<script>
  import axios from 'axios';
  export default {
      name:"Checkbox",
    data() {
      return {
        categories:{
          category_id: '',
          name:'',
        },
        info: null,
        category: [],
        selected: [], // Must be an array reference!
      }
    },
    mounted () {
    axios
      .get('https://98ac56da56a5.ap.ngrok.io/restaurants/category?currentNumber=0&requiredNumber=10')
      .then(response => (this.categories = response.data))
    },
    methods:
    {
      onChange()
      {
        this.$emit("selectChange",this.selected)
      },
    },
  }
</script>

<style scopped>
  .checkboxHeader{
    text-align: left;
    color: black;
    padding-left: 2%;
    
    border-bottom:1px solid gray ;
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