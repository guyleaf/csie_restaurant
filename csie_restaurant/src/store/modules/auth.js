const state = () => ({
  user: null,
  token: null,
  exp: null,
});

const getters = {
  token: (state) => state.token,
  user: (state) => state.user,
  expired: (state) => {
    return !state.token || state.exp < Date.now();
  },
};

const mutations = {
  SET_USER: (state, payload) => (state.user = payload),
  SET_TOKEN: (state, payload) => (state.token = payload),
  SET_EXPIRE_DATE: (state, payload) => (state.exp = payload),
  INVALIDATE_TOKEN: (state) => (state.token = state.exp = null),
  INVALIDATE_USER: (state) => (state.user = null),
};

const actions = {
  setUser: ({ commit }, payload) => commit("SET_USER", payload),
  setToken: ({ commit }, payload) => commit("SET_TOKEN", payload),
  setExpireDate: ({ commit }, payload) => commit("SET_EXPIRE_DATE", payload),
  invalidate: ({ commit }) => {
    commit("INVALIDATE_USER");
    commit("INVALIDATE_TOKEN");
  },
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
