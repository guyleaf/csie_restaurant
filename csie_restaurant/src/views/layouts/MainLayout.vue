<template>
    <div>
        <MainHeader />
        <div class="container">
            <router-view />
        </div>
        <MainFooter />
    </div>
</template>

<script>
// @ is an alias to /src
import MainHeader from "@/components/shared/MainHeader.vue";
import MainFooter from "@/components/shared/MainFooter.vue";
export default {
    name: "main-layout",
    components: {
        MainHeader,
        MainFooter
    },
    data: function() {
        return {};
    },
    computed: {
    },
    beforeCreate: function() {},
    created: function() {},
    beforeMount: function() {},
    mounted: function() {},
    beforeUpdate: function() {},
    updated: function() {},
    activated: function() {},
    deactivated: function() {},
    beforeDestroy: function() {},
    destroyed: function() {},
    errorCaptured: function() {}
};
</script>

<style scoped>
</style>