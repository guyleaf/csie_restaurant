<template>
    <div class="container row justify-content-center">
        <div class="col-3">
            <ManageTab />
        </div>
        <div class="col-9">
            <router-view />
        </div>
    </div>
</template>

<script>
import ManageTab from "@/components/ManageTab.vue";
export default {
    name: "manage-layout",
    components: {
        ManageTab,
    },
}
</script>
<style scopped>
  .container{
    max-width:100% !important; 
    padding: 0% !important;
    margin: 0% 1% 0% 1%;
    overflow: hidden;
  }
</style>