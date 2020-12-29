import Vue from 'vue'
import Vuex from 'vuex'
import router from 'vue-router'

Vue.use(Vuex)
//註冊狀態管理全域性引數
var store = new Vuex.Store({
  state:{
    token:'',
    user:null,
    loading:false
  },
  actions:{
    onSubmitSignin ({commit}, payload) {
      commit('setLoading', true)
      return new Promise( (resolve, reject) =>{
        this.$http.post('/auth/login', payload)
          .then((response) => {
              console.log(response.data)
              window.localStorage.setItem('token', response.headers['token'])
              commit('setUser',response.data)
              commit('setLoading', false)
              resolve()
          }).catch((err) => {
              commit('setLoading', false)
              reject(err.response.data)
          })
      })
    },
    onSubmitLogout ({commit}) {
      var token = window.localStorage.getItem('token')
      return new Promise((resolve,reject) => {
        this.$http('/auth/logout', {headers: {token}})
        .then( (response) => {
          console.log(response.data)
          window.localStorage.removeItem('token')
          commit('setUser', null)
          resolve()
        }).catch( (err) => {
          console.log(err)
          reject()
        })
      })
    }
  },
  mutations: {
    setUser (state, payload){
      state.user = payload
    },
    setLoading (state, payload){
      state.loading = payload
    }
  },
  getter:{
    getUser (state){
        return state.user
    }
  },
  modules:{

  },
});

router.beforeEach((to, from, next) => {
   
  store.state.token = sessionStorage.getItem('token');//獲取本地儲存的token
   
  if (to.meta.requireAuth) { // 判斷該路由是否需要登入許可權
  if (store.state.token !== "") { // 通過vuex state獲取當前的token是否存
   next();
  }
  else {
   next({
   path: '/login',
   query: {redirect: to.fullPath} // 將跳轉的路由path作為引數，登入成功後跳轉到該路由
   })
  }
  }
  else {
  next();
  }
})