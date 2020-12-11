<template>
    <div>
    <b-form-group label-class="checkboxHeader">
      <div v-for="option in options" :key="option.value" class="checkboxMenuPadding">
        <b-form-checkbox class="checkboxMenu"
          v-model="selected"
          :value="option.value"
        >
          {{ option }}
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
            options:["會員管理","店家管理","報表統計"],  
        }
    },
}
</script>