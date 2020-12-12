<template>
  <div>
    <b-form-group label="商店種類" label-class="checkboxHeader">
    <div class="checkboxMenu row mt-1">
      <b-form-radio class="mb-1 checkbox"
        v-model="selected"
        @change="onChange()"
        v-for="option in options"
        :key="option.id"
        :value="option.path"
        button
        button-variant="none"
      >
      {{ option.label }}
      </b-form-radio>
      
    </div>
    </b-form-group>
  </div>
</template>

<script>
export default {
    name: "ManageTab",
    data(){
        return{
            selected: '',
            options:[
                {id:1, label:"會員管理", path:'manage'},
                {id:2, label:"店家管理", path:'shop'},
                {id:3, label:"報表統計", path:"salesReport"}
                ],  
        }
    },
    methods:{
        onChange(){
            if(!this.selected) this.$router.push("/manage/")
            else this.$router.push("/manage/"+this.selected)
            console.log(this.selected)
        }
    }
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
    margin: 0;
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