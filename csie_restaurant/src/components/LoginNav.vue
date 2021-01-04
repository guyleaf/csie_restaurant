<template>
  <div>
    <b-button v-if="loginState===-1" @click="showModal">Login</b-button>
    <span v-else :text="loginMsg"></span>
    <LoginForm @close="closeModal" />
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

    },
    data() {
      return {
        loginState: -1,
        loginMsg: null,
      }
    },
    methods: {
      showModal() {
          this.$bvModal.show('login-modal')
          this.$bvModal.reset()
      },
      closeModal() {
          this.$bvModal.hide('login-modal')
      },
    }
  }
</script>

<style scoped>

</style>