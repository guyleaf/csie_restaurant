<template>
  <div>
    <b-button class="mr-1" v-if="!logined" @click="showSignUpModal">SignUp</b-button>
    <b-button class="ml-1" v-if="!logined" @click="showLoginModal">Login</b-button>
    <b-dropdown v-else id="dropdown" :text="loginMsg" class="m-md-2" right style="min-width: 4rem">
      <b-dropdown-item :to="{name: 'History'}" v-if="this.$store.getters['auth/user'].permission==2">History</b-dropdown-item>
      <b-dropdown-item :to="{name: 'ShopManage'}" v-if="this.$store.getters['auth/user'].permission==1">ShopManage</b-dropdown-item>
      <b-dropdown-item :to="{name: 'SalesReport'}" v-if="this.$store.getters['auth/user'].permission<=1">Manage</b-dropdown-item>
      <b-dropdown-item @click="logout">Logout</b-dropdown-item>
    </b-dropdown>
    <SignUpForm ref="SignUp" @close="closeModal"/>
    <LoginForm ref="form" @close="closeModal" @success="loginSuccess"/>
  </div>
</template>

<script>
  import LoginForm from '@/components/LoginForm.vue'
  import SignUpForm from '@/components/SignUpForm.vue'
  import jwt_decode from "jwt-decode"
  export default {
    name: 'LoginNav',
    components: {
      LoginForm,
      SignUpForm
    },
    beforeMount() {
      if (!this.$store.getters['auth/expired']) {
        this.loginSuccess(this.$store.getters['auth/user'].name)
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
      showLoginModal() {
        this.$refs.form.reset()
        this.$bvModal.show('login-modal')
      },
      showSignUpModal(){
        this.$refs.SignUp.reset()
        this.$bvModal.show('signUp-modal')
      },
      closeModal() {
        this.$refs.form.reset()
        this.$refs.SignUp.reset()
        this.$bvModal.hide('login-modal')
        this.$bvModal.hide('signUp-modal')
      },
      loginSuccess(name) {
        this.logined = true
        this.loginMsg = 'Hi ' + name
      },
      logout() {
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
          if (this.$route.path != "/")
            this.$router.push("/")
        }).catch(error => {
          this.logined = false
          this.$store.dispatch('auth/invalidate')
          this.$fire({
            title: "登出成功",
            text: 'Successfully logged out',
            type: "success",
            timer: 5000
          })
          if (this.$route.path != "/")
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