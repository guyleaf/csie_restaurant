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
                <b-nav-item> 
                    <router-link :to="{name: 'Cashier'}" class="nav-link">Cashier</router-link>
                </b-nav-item>
                <b-nav-item> 
                    <router-link :to="{name: 'ShopManage'}" class="nav-link">ShopManage</router-link>
                </b-nav-item>
            </b-navbar-nav>
            
            <!-- Right aligned nav items -->

            <b-nav-form class="ml-auto">
                <b-input-group size="sm">
                    <b-form-input type="search" placeholder="Search terms"></b-form-input>
                    <b-input-group-prepend is-text>
                        <b-icon icon="search" @click="search"></b-icon>
                    </b-input-group-prepend>
                </b-input-group>
            </b-nav-form>
            <b-navbar-nav class="ml-5 mr-3">
                <ShoppingCart />
            </b-navbar-nav>
            <b-navbar-nav>
                <LoginNav />
            </b-navbar-nav>
            <!-- <b-navbar-nav>
                <b-nav-item> 
                    <router-link :to="{name: 'SalesReport'}" class="nav-link manage">Manage</router-link>
                </b-nav-item>
            </b-navbar-nav> -->
            </b-collapse>
        </b-navbar>
    </div>
</template>

<script>
import ShoppingCart from "@/components/ShoppingCart.vue";
import LoginNav from "@/components/LoginNav.vue";
// @ is an alias to /src
export default {
    name: "main-header",
    components: {
        ShoppingCart,
        LoginNav
    },
    data: function() {
        return {
        };
    },
    method: {
        showHistory() {
        }
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