const state = () => ({
    user: null,
    token: null,
    exp: null
})

const getters = {  
    token: state => state.token,
    user: state => state.user,
    expired: state => {
        return state.exp && state.exp < Date.now()
    }
}

const mutations = {
    SET_USER: (state, payload) => state.user = user,
    SET_TOKEN: (state, payload) => state.token = payload,
    INVALIDATE_TOKEN: (state) => state.token = null,
    INVALIDATE_USER: (state) => state.user = null
}

const actions = {
    setUser: ({ commit }, payload) => commit('SET_USER', payload),
    setToken: ({ commit }, payload) => commit('SET_TOKEN', payload),
    invalidate: ({ commit }) => {
        commit('INVALIDATE_USER')
        commit('INVALIDATE_TOKEN')
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}