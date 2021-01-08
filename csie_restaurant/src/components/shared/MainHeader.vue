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
                <b-input-group size="sm" >
                    <b-form-input type="search" placeholder="Search terms" list="result" v-model="keywords" debounce="700"></b-form-input>
                    
                    <b-input-group-prepend>
                        <b-button variant="success" @click="go()">search</b-button>
                    </b-input-group-prepend>
                </b-input-group>
            </b-nav-form>
            <b-navbar-nav class="ml-4 mr-3">
                <ShoppingCart />
            </b-navbar-nav>
            <b-navbar-nav>
                <LoginNav ref="loginNav"></LoginNav>
            </b-navbar-nav>
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
            keywords: '',
            search_result: []
        };
    },
    method: {
        showHistory() {
        },
        go() {
            
        }
    },
    computed: {
    },
    watch: {
        keywords: function (newKey, oldKey) {
            let keywords = newKey.split(" ").map(x => 'keywords[]=' + x)
            let url = '/restaurants/search?' + keywords.join('&')
            this.$axios.get(this.$url + url)
            .then(response => {
                console.log(response)
                this.search_result = response.data
            })
            .catch(error => {
                console.log(error)
            })
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
a {
    color: white;
}
a:hover {
    color: white;
}
</style>