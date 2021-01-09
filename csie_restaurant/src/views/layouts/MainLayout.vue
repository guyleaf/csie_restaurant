<template>
    <div class="html">
        <MainHeader class="navigation"/>
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
        var html = document.querySelector('.html')
        var body = document.querySelector('.body')
        var header = document.querySelector('.header')
        var footer = document.querySelector('.bottom')
        var fixed = document.querySelector('#fixed')
        var footerHeight = footer.clientHeight
        var bodyHeight =html.clientHeight - footerHeight - header.clientHeight
        fixed.style.minHeight = header.clientHeight.toString() +"px"
        body.style.minHeight = bodyHeight.toString()+"px"
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

<style>
  .html{
      min-height: 100vh
  }
  .container{
    min-width:100% !important; 
    margin: 0 !important;
    padding: 0% !important;
    overflow: hidden;
  }
  .categoryTabs{
      left: 0;
      z-index: 19;
      background-color: white;
      position: fixed;
  }
  .navigation{
      width: 100%;
      top: 0;
      left: 0;
      z-index: 20;
      position: sticky;
  }
</style>