import Vue from "vue"
import Vuex from "vuex"
import createPersistedState from "vuex-persistedstate"
import SecureLS from "secure-ls"
import authStore from "./modules/auth"

const ls = new SecureLS({ isCompression: false })

Vue.use(Vuex)

const auth = createPersistedState({
    key: 'auth',
    paths: [
      'auth',
      'auth.user',
      'auth.token',
      'auth.exp'
    ],
    storage: {
        getItem: key => ls.get(key),
        setItem: (key, value) => ls.set(key, value),
        removeItem: key => ls.remove(key)
    }
})

const store = new Vuex.Store({
    modules: {
        auth: authStore
    },
    plugins: [
        auth
    ]
});

export default store;