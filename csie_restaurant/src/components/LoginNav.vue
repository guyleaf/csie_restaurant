<template>
  <div>
    <b-button v-if="loginState===-1" @click="showModal">Login</b-button>
    <b-dropdown v-else id="login-dropdown" :text="loginMsg" class="m-md-2">
        <b-dropdown-item v-if="loginState===1" :to="{name: 'History'}">HistoryForUser</b-dropdown-item>
        <b-dropdown-item v-if="loginState===2 || loginState===3" :to="{name: 'SalesReport'}" >ReportForShop</b-dropdown-item>
        <b-dropdown-item v-if="loginState===3" :to="{name: 'Member'}" >MemberForAdmin</b-dropdown-item>
        <b-dropdown-item disabled>Third Action</b-dropdown-item>
        <b-dropdown-divider></b-dropdown-divider>
        <b-dropdown-item variant="danger" >Log off</b-dropdown-item>
    </b-dropdown>
    <b-modal id="login-modal" size="sm" ref="modal" title="會員登入" @show="resetModal" @hidden="resetModal" hide-footer hide-header-close>
      <form ref="form" @submit.stop.prevent="handleSubmit" >
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
      <div class="row m-2" style="justify-content:space-around">
          <b-button variant="info" @click="handleSubmit" size="sm">CONFIRM</b-button>
          <b-button variant="danger" @click="closeModal" size="sm">CANCEL</b-button>
      </div>
    </b-modal>
  </div>
</template>

<script>
  export default {
    name: 'LoginNav',
    data() {
      return {
        accountState: null,
        passwordState: null,
        loginState: -1,
        loginMsg: null,
        userInfo:{
          account:'',
          password:'',   
        },
        fakeUser:{
            account:'user',
            password:'user',
            name:'87Roger'
        },
        fakeShop:{
            account:'shop',
            password:'shop',
            name:'66Lee'
        },
        fakeAdmin:{
            account:'admin',
            password:'admin',
            name:'NiceRon'
        }
      }
    },
    methods: {
      checkFormValidity() {
        const valid1 = this.$refs['account-input'].checkValidity()
        const valid2 = this.$refs['password-input'].checkValidity()
        this.accountState = valid1
        this.passwordState = valid2
        return valid1 && valid2
      },
      resetModal() {
        this.userInfo.account=''
        this.userInfo.password=''
        this.accountState = null
        this.passwordState = null
      },
      handleSubmit() {
        // Exit when the form isn't valid
        if (!this.checkFormValidity()) {
          return
        }
        this.userInfo.account = this.account
        this.userInfo.password = this.password
        
        console.log(this.account, this.password)
        this.verification()
      },
      verification(){
         
        if(this.userInfo.account==this.fakeUser.account && this.userInfo.password==this.fakeUser.password){
            this.loginState = 1
            this.loginMsg = 'Hi ' + this.fakeUser.name
            this.$bvModal.hide('login-modal')
        }
        else if(this.userInfo.account==this.fakeShop.account && this.userInfo.password==this.fakeShop.password){
            this.loginState = 2
            this.loginMsg = 'Hi ' + this.fakeShop.name
            this.$bvModal.hide('login-modal')
        }
        else if(this.userInfo.account==this.fakeAdmin.account && this.userInfo.password==this.fakeAdmin.password){
            this.loginState = 3
            this.loginMsg = 'Hi ' + this.fakeAdmin.name
            this.$bvModal.hide('login-modal')
        }
        else{
            this.loginState = -1
            this.accountState = null
            this.passwordState = null
            alert('輸入錯誤帳號或密碼')
        }
      },
      showModal() {
          this.$bvModal.show('login-modal')
          this.resetModal()
      },
      closeModal() {
          this.$bvModal.hide('login-modal')
          this.resetModal()
      },
    }
  }
</script>

<style scoped>

</style>