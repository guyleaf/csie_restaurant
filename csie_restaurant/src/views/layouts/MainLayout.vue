<template>
    <div>
        <MainHeader />
        <div class="container body">
            <router-view />
        </div>
        <MainFooter />
    </div>
</template>

<script>
// @ is an alias to /src
import Vue from 'vue';
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
    beforeCreate: function() {},
    created: function() {},
    beforeMount: function() {},
    mounted: function() {
        var body = document.querySelector('.body')
        var header = document.querySelector('.header')
        var footer = document.querySelector('.bottom')
        var footerHeight = footer.clientHeight 
        body.style.minHeight ="100vh"
        var bodyHeight = body.clientHeight - footerHeight - header.clientHeight
        body.style.minHeight= bodyHeight.toString()+"px"
    },  
    beforeUpdate: function() {},
    updated: function() {},
    activated: function() {},
    deactivated: function() {},
    beforeDestroy: function() {},
    destroyed: function() {},
    errorCaptured: function() {}
};
  Vue.prototype.$bus = new Vue();
</script>

<style scoped>

</style>