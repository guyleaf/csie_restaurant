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
                    <b-form-input list="searchInput" placeholder="Search Shop" v-model="keywords" debounce="700"></b-form-input>
                    <datalist id="searchInput">
                        <option v-for="name in search_shopName" :key="name"> {{ name }}</option>
                    </datalist>
                    <b-input-group-prepend >
                        <b-button variant="success" @click="goShop">Search</b-button>
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
            search_result: [],
            search_shopName: [], //options
        };
    },
    methods: {
        showHistory() {
        },
        goHome(){
            this.$store.dispatch('auth/setSearchResult', this.search_result);
            console.log('homeClean',this.$store.getters['auth/searchResult'])
            this.$router.push({name: 'Home'}); 
            console.log('pushHome')
            // window.location.reload(); //FIXME
        },
        goSearch(){
            let search = document.querySelector('#searchInput').textContent
            if (search.trim()==''){
                console.log('NOTFOUND');
                //FIXME SHOW NOT FOUND MODAL
                return
            }
            console.log('search',this.search_result);
            this.$store.dispatch('auth/setSearchResult', this.search_result);
            this.$router.push('/')
        },
        goShop() {
            let search = document.querySelector('#searchInput').textContent
            if (search.trim()==''){
                console.log('NOTFOUND');
                //FIXME SHOW NOT FOUND MODAL
                return
            }
            // let path = '/shop/' + this.search_result[0].seller_id + '/' + search.trim();
            // this.$router.push(path);
            // console.log('emittt')
            this.$store.dispatch('auth/setSearchResult', this.search_result);
            // console.log('123',this.$store.getters['auth/searchResult'])
            this.$bus.$emit('reloadShop', this.search_result);
            // this.$router.pushf
            console.log('enddd')
            
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
                this.search_result = response.data;
                console.log('22222222222',this.search_result);
                this.search_shopName = [];
                for(let i=0;i<this.search_result.length ;i++){
                    this.search_shopName.push(this.search_result[i].name);
                }
                
            })
            .catch(error => {
                console.log(error)
            })
        },
        
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