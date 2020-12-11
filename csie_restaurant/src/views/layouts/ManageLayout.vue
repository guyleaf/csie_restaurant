<template>
    <div class="row">
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