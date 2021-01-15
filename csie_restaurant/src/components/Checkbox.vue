<template>
  <div>
    <b-form-group label="商店種類" label-class="checkboxHeader">
    <div class="checkboxMenu row mt-1">
      <b-form-checkbox class="mb-1 checkbox"
        v-model="selected"
        v-for="category in categories"
        :key="category.category_id"
        :value="category.category_id"
        button
        button-variant="none"
        @change="selecting"
      >
        {{ category.name }}
      </b-form-checkbox>
    </div>
    </b-form-group>
  </div>
</template>

<script>
  export default {
    name:"Checkbox",
    props: {
      categories: Array
    },
    data() {
      return {
        selected: [], // Must be an array reference!
      }
    },
    mounted() {
       this.$bus.$on('resetHome', () => {
         this.selected = []
       });
       this.$bus.$on('reloadHome', () => {
         this.selected = []
       });
    },
    watch:
    {
      
    },
    methods:
    {
      selecting: function () {
        // console.log('selecting..');
        this.$emit("selectChange", this.selected)
      }
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