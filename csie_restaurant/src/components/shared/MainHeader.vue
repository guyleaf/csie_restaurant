<template>
    <div>
        <b-navbar toggleable="lg" type="dark" variant="dark" class='header'>
            <b-navbar-brand> 
                <router-link :to="{name: 'Home'}" class="nav-link" variant="info">孜宮庭園</router-link>
            </b-navbar-brand>

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
            <b-navbar-nav>
                <b-nav-item> 
                    <router-link :to="{name: 'Home'}" class="nav-link">Home</router-link>
                </b-nav-item>
            </b-navbar-nav>
            
            <!-- Right aligned nav items -->

            <b-nav-form class="ml-auto">
                <b-form-input size="sm" class="mr-sm-2" placeholder="Search"></b-form-input>
                <b-button size="sm" class="my-2 my-sm-0" type="submit" variant="success">button</b-button> <!--input type="image" src="" /-->
            </b-nav-form>
            <b-navbar-nav class="ml-5">
                <ShoppingCart />
            </b-navbar-nav>
            <b-navbar-nav>
                <b-nav-item> 
                    <router-link :to="{name: 'Login'}" class="nav-link login">Login</router-link>
                </b-nav-item>
            </b-navbar-nav>
            <b-navbar-nav>
                <b-nav-item> 
                    <router-link :to="{name: 'SalesReport'}" class="nav-link manage">Manage</router-link>
                </b-nav-item>
            </b-navbar-nav>
            <b-navbar-nav>
                <b-nav-item> 
                    <router-link :to="{name: 'History'}" class="nav-link manage">History</router-link>
                </b-nav-item>
            </b-navbar-nav>
            </b-collapse>
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
        ShoppingCart,
    },
    data: function() {
        return {
        };
    },
    method: {
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
a {
    color: white;
}
a:hover {
    color: white;
}
</style>