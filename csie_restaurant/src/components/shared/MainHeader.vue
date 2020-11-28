<template>
    <div>
        <b-navbar toggleable="lg" type="light" variant="faded">
            <b-navbar-brand href="#">NavBar</b-navbar-brand>

            <b-navbar-nav class="navbar-nav mr-auto">
                <router-link :to="{name: 'Home'}" class="nav-link">Home</router-link>
            </b-navbar-nav>

            <b-navbar-nav>
                <ShoppingCart />
            </b-navbar-nav>

            <b-navbar-nav>
                <router-link :to="{name: 'Login'}" class="nav-link">Login</router-link>
            </b-navbar-nav>

        </b-navbar>
    </div>
</template>

<script>
import ShoppingCart from "@/components/ShoppingCart.vue";
// @ is an alias to /src
// import HelloWorld from "@/components/HelloWorld.vue";
export default {
    name: "main-header",
    components: {
        // HelloWorld
        ShoppingCart
    },
    data: function() {
        return {};
    },
    computed: {
        displayYMD() {
            return new Date().getFullYear().toString();
        }
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