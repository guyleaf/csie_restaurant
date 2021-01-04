<template>
  <div>
    <b-button v-if="!logined" @click="showModal">Login</b-button>
    <span v-else>{{ loginMsg }}</span>
    <LoginForm ref="form" @close="closeModal" @success="loginSucess"/>
  </div>
</template>

<script>
  import LoginForm from '@/components/LoginForm.vue'
  export default {
    name: 'LoginNav',
    components: {
      LoginForm
    },
    beforeMount() {
      if (!this.$store.getters['auth/expired']) {
        this.loginSucess('qqq')
      }
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
      }
    }
  }
</script>

<style scoped>

</style>