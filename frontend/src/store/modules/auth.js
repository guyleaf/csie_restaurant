const state = () => ({
  user: null,
  token: null,
  exp: null,
  searchResult: [],
  keywords: "",
});

const getters = {
  token: (state) => state.token,
  user: (state) => state.user,
  expired: (state) => {
    return !state.token || state.exp < Date.now();
  },
  searchResult: (state) => state.searchResult,
  keywords: (state) => state.keywords,
};

const mutations = {
  SET_USER: (state, payload) => (state.user = payload),
  SET_TOKEN: (state, payload) => (state.token = payload),
  SET_EXPIRE_DATE: (state, payload) => (state.exp = payload),
  INVALIDATE_TOKEN: (state) => (state.token = state.exp = null),
  INVALIDATE_USER: (state) => (state.user = null),
  SET_SEARCH_RESULT: (state, payload) => (state.searchResult = payload),
  INVALIDATE_SEARCH_RESULT: (state) => (state.searchResult = []),
  SET_KEYWORDS: (state, payload) => (state.keywords = payload),
  INVALIDATE_KEYWORDS: (state) => (state.keywords = ""),
};

const actions = {
  setUser: ({ commit }, payload) => commit("SET_USER", payload),
  setToken: ({ commit }, payload) => commit("SET_TOKEN", payload),
  setExpireDate: ({ commit }, payload) => commit("SET_EXPIRE_DATE", payload),
  invalidate: ({ commit }) => {
    commit("INVALIDATE_USER");
    commit("INVALIDATE_TOKEN");
    commit("INVALIDATE_SEARCH_RESULT");
  },
  setSearchResult: ({ commit }, payload) =>
    commit("SET_SEARCH_RESULT", payload),
  cleanSearchResult: ({ commit }) => commit("INVALIDATE_SEARCH_RESULT"),
  setKeywords: ({ commit }, payload) => commit("SET_KEYWORDS", payload),
  cleanKeywords: ({ commit }) => commit("INVALIDATE_KEYWORDS"),
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
