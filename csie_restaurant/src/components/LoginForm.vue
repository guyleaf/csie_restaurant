<template>
  <div>
    <b-modal id="login-modal" size="sm" ref="modal" title="會員登入" hide-footer hide-header-close>
      <form ref="form" @submit.stop.prevent="submit">
        <b-form-group
          label="Account"
          label-for="account-input"
          invalid-feedback="Account is required"
          :state="accountState"
        >
          <b-form-input
            ref="account-input"
            v-model="account"
            :state="accountState"
            required
          ></b-form-input>
        </b-form-group>
        <b-form-group
          label="Password"
          label-for="password-input"
          invalid-feedback="Password is required"
          :state="passwordState"
        >
          <b-form-input
            ref="password-input"
            v-model="password"
            :state="passwordState"
            required
          ></b-form-input>
        </b-form-group>
      </form>
      <b-alert fade :show="showAlert" variant="danger">{{ errorMsg }}</b-alert>
      <div class="row m-2" style="justify-content:space-around">
          <b-button variant="info" @click="submit" size="sm">CONFIRM</b-button>
          <b-button variant="danger" @click="$emit('close')" size="sm">CANCEL</b-button>
      </div>
    </b-modal>
  </div>
</template>

<script>
  export default {
    name: 'LoginForm',
    data() {
        return {
            account: null,
            password: null,
            showAlert: false,
            errorMsg: ''
        }
    },
    computed: {
      accountState() {
          if (this.account === null) {
              return null
          }

          return this.account.length > 0
      },
      passwordState() {
          if (this.password === null) {
              return null
          }

          return this.password.length > 0
      }
    },
    methods: {
      checkFormValidity() {
        const valid1 = this.$refs['account-input'].checkValidity()
        const valid2 = this.$refs['password-input'].checkValidity()
        return valid1 && valid2
      },
      submit() {
        // Exit when the form isn't valid
        if (!this.checkFormValidity()) {
          this.account = ''
          this.password = ''
          return
        }

        this.$_verification(this.account, this.password)
      },
      $_verification(account, password) {
        let url='/auth/login';
        this.$axios.post(this.$url + url, {
          username: this.account,
          password: this.password
        })
        .then(response => {
          this.showAlert = false
          let data = response.data
          this.$store.dispatch('auth/setToken', data.access_token)
          this.$store.dispatch('auth/setExpireDate', Date.now() + data.expires_in * 1000)
          this.$emit('success', 'asd')
          this.$emit('close')
        })
        .catch(error => {
          let status = error.response.status
          switch (status) {
            case 401:
              this.errorMsg = 'Invalid account or password';
              this.showAlert = true;
              break;
            case 500:
              this.errorMsg = 'Unknown error';
              this.showAlert = true;
              break;
          }

          this.account = null
          this.password = null
        })
      },
      reset() {
        this.account = null
        this.password = null
        this.showAlert = false
      }
    }
  }
</script>

<style scoped>

</style>