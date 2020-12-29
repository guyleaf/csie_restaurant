<template>
  <div>
    <b-button v-if="loginState===-1" @click="showModal">Login</b-button>
    <b-dropdown v-else id="login-dropdown" :text="loginMsg" class="m-md-2">
        <b-dropdown-item v-if="loginState===1" :to="{name: 'History'}">HistoryForUser</b-dropdown-item>
        <b-dropdown-item v-if="loginState===2 || loginState===3" :to="{name: 'SalesReport'}" >ReportForShop</b-dropdown-item>
        <b-dropdown-item v-if="loginState===3" :to="{name: 'Member'}" >MemberForAdmin</b-dropdown-item>
        <b-dropdown-item disabled>Third Action</b-dropdown-item>
        <b-dropdown-divider></b-dropdown-divider>
        <b-dropdown-item variant="danger" @click="handleLogout">Log out</b-dropdown-item>
    </b-dropdown>
    <b-modal id="login-modal" size="sm" ref="modal" title="會員登入" @show="resetModal" @hidden="resetModal" hide-footer hide-header-close>
      <form ref="form" @submit.prevent="handleSubmit" >
        <div class="form-group">
          <label for="Username"></label>
          <input type="text" id="username" class="form-control" placeholder="Enter Username" v-model="username" required>
        </div>
        <div class="form-group">
          <label for="Password"></label>
          <input type="password" id="password" class="form-control" placeholder="Enter Password" v-model="password" required>
        </div>
        <button type="submit" class="btn btn-primary" :disabled="loading">
          <span v-if="!loading">Submit</span>
          <span v-if="loading"><i class="fa fa-spinner" aria-hidden="true"></i> Loading... </span>
        </button>
        <button class="btn btn-danger" @click="closeModal"> CANCEL </button>
      </form>
    </b-modal>
  </div>
</template>

<script>
import { mapState } from 'vuex'
export default {
    name: 'LoginNav',
    data() {
      return {
        username:'',
        password:'',  
        status: null, 
        loginMsg: 'Login',
      }
    },
    computed:{
      ...mapState({
        loading: state => state.user.loading
      })
    },
    methods: {
      resetModal() {
        this.username=''
        this.password=''
      },
      handleSubmit() {
        // Exit when the form isn't valid
        this.$store.dispatch('onSubmitSignin', {username: this.username, password: this.password})
        .then((result) => {
            console.log(result)
            this.loginMsg = 'Hi' + this.username
        }).catch( (err) =>{
            console.log(err);
        })
      },
      handleLogout() {
        this.$store.dispatch('onSubmitLogout')
        .then((result) => {
            console.log(result)
            this.loginMsg = 'Login'
        }).catch( (err) =>{             
            console.log(err);
        })
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