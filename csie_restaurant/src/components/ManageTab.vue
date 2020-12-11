<template>
  <div>
    <b-form-group label="商店種類" label-class="checkboxHeader">
    <div class="checkboxMenu row mt-1">
      <b-form-checkbox class="mb-1 checkbox"
        v-model="selected"
        @change="onChange()"
        v-for="option in options"
        :key="option.id"
        :value="option.path"
        button
        button-variant="none"
      >
        {{ option.label }}
      </b-form-checkbox>
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
                {id:3, label:"報表統計", path:"money"}
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