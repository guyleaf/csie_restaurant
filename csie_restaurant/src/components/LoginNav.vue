<template>
  <div>
    <b-button v-if="!logined" @click="showModal">Login</b-button>
    <b-dropdown v-else id="dropdown" :text="loginMsg" class="m-md-2" right style="min-width: 4rem">
      <b-dropdown-item><b-link :to="{name: 'History'}">History</b-link></b-dropdown-item>
      <b-dropdown-item v-if="this.$store.getters['auth/user'].permission==1"><b-link :to="{name: 'ShopManage'}">ProductsManage</b-link></b-dropdown-item>
      <b-dropdown-item v-if="this.$store.getters['auth/user'].permission<=1"><b-link :to="{name: 'SalesReport'}">Manage</b-link></b-dropdown-item>
      <b-dropdown-item @click="logout">Logout</b-dropdown-item>
    </b-dropdown>
    <LoginForm ref="form" @close="closeModal" @success="loginSucess"/>
  </div>
</template>

<script>
  import LoginForm from '@/components/LoginForm.vue'
  import jwt_decode from "jwt-decode"
  export default {
    name: 'LoginNav',
    components: {
      LoginForm
    },
    beforeMount() {
      if (!this.$store.getters['auth/expired']) {
        this.loginSucess(this.$store.getters['auth/user'].name)
      }
      else if (this.$store.getters['auth/token'] != null)
        this.refreshToken(this.$store.getters['auth/token'])
      else
        this.$store.dispatch('auth/invalidate')
    },
    data() {
      return {
        logined: false,
        loginMsg: null,
      }
    },
    methods: {
      showModal() {
        this.$refs.form.reset()
        this.$bvModal.show('login-modal')
      },
      closeModal() {
        this.$refs.form.reset()
        this.$bvModal.hide('login-modal')
      },
      loginSucess(name) {
        this.logined = true
        this.loginMsg = 'Hi ' + name
      },
      logout() {
        console.log(this.$store.getters['auth/token'])
        let url='/auth/logout';
        this.$axios.post(this.$url + url, {}, {
          headers: {
            'Authorization': 'Bearer ' + this.$store.getters['auth/token']
          }
        })
        .then(response => {
          this.logined = false
          this.$store.dispatch('auth/invalidate')
          this.$fire({
            title: "登出成功",
            text: response.data.message,
            type: "success",
            timer: 5000
          })
          this.$router.push("/")
        })
      },
      refreshToken(token) {
        let url='/auth/refresh';
        this.$axios.post(this.$url + url, {}, {
          headers: {
            'Authorization': 'Bearer ' + token
          }
        })
        .then(response => {
          let data = response.data
          let token = jwt_decode(data.access_token)
          this.$store.dispatch('auth/setToken', data.access_token)
          this.$store.dispatch('auth/setExpireDate', token.exp)
          this.$store.dispatch('auth/setUser', token.user)
          this.$emit('success', token.user.name)
          this.$emit('close')
        })
        .catch(error => {
          this.$store.dispatch('auth/invalidate')
          this.$router.push("/")
        })
      }
    }
  }
</script>

<style scoped>
  a {
    color: black;
    text-decoration: none;
  }

  a:hover {
    text-decoration: none;
  }
</style>