<template>
    <div>
        <b-navbar toggleable="lg" type="dark" variant="dark" class='header'>
            <b-navbar-brand @click="goHome" class="nav-link" variant="info"> 
                孜宮庭園
            </b-navbar-brand>
            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
            <b-collapse id="nav-collapse" is-nav>
            <b-navbar-nav>
                <b-nav-item @click="goHome" class="nav-link" variant="info"> 
                    Home
                </b-nav-item>
            </b-navbar-nav>
            <!-- Right aligned nav items -->
            <b-nav-form class="ml-auto">
                <b-input-group size="sm" >
                    <b-form-input list="searchInput" placeholder="Search Shop" v-model="keywords" debounce="500"></b-form-input>
                    <datalist id="searchInput">
                        <option v-for="name in search_shopName" :key="name"> {{ name }}</option>
                    </datalist>
                    <b-input-group-prepend >
                        <b-button variant="success" @click="goSearch">Search</b-button>
                    </b-input-group-prepend>
                </b-input-group>
            </b-nav-form>
            <b-navbar-nav class="ml-4 mr-3">
                <ShoppingCart v-if="this.$store.getters['auth/token'] == null || this.$store.getters['auth/user'].permission==2 && 
                showShoppingCart"/>
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
            search_result: [],
            search_shopName: [], //options
            showShoppingCart: true
        };
    },
    methods: {
        reset() {
            this.keywords = ''
            this.search_result = []
            this.$store.dispatch('auth/cleanSearchResult');
            this.$store.dispatch('auth/cleanKeywords');
        },
        showHistory() {
        },
        goHome(){
            this.reset()
            this.$bus.$emit('resetHome');
            if (this.$route.path != '/')
                this.$router.push('/')
        },
        goSearch() {
            //let search = document.querySelector('#searchInput').textContent
            this.$store.dispatch('auth/setSearchResult', this.search_result);
            this.$store.dispatch('auth/setKeywords', this.keywords);
            this.$bus.$emit('reloadHome');
            if (this.$route.path != '/')
                this.$router.push('/')
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
                // // console.log(response)
                this.search_result = response.data;
                this.search_shopName = [];
                for(let i=0;i<this.search_result.length ;i++){
                    this.search_shopName.push(this.search_result[i].name);
                }
            })
            .catch(error => {
                console.log(error.response)
            })
        
        },
        $route: {
            handler: function() {
                if(this.$router.currentRoute['name'] == "Cashier") this.showShoppingCart = false;
                else this.showShoppingCart = true;
            },
         },
    },
    created: function() {
        if(this.$router.currentRoute['name'] == "Cashier") this.showShoppingCart = false;
        else this.showShoppingCart = true;
    },
    beforeCreate: function() {},
    beforeMount: function() {},
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