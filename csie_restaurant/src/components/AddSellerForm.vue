<template>
  <div>
    <b-modal id="addSeller-modal" size="lg" ref="modal" title="店家註冊" hide-footer hide-header-close>
      <form ref="AddSeller" @submit.stop.prevent="submit">
        <b-row>
        <b-col md='6'>
        <b-form-group
          label="暱稱"
          label-for="name-input"
          invalid-feedback="暱稱不可為空"
          :state="nameState"
        >
          <b-form-input
            ref="name-input"
            v-model="name"
            :state="nameState"
            required
          ></b-form-input>
        </b-form-group>
        <b-form-group
          label="帳號"
          label-for="username-input"
          invalid-feedback="帳號不可為空"
          :state="usernameState"
        >
          <b-form-input
            ref="username-input"
            v-model="username"
            type="text"
            :state="usernameState"
            required
          ></b-form-input>
        </b-form-group>
        <b-form-group
          label="密碼"
          label-for="password-input"
          invalid-feedback="密碼不可為空"
          :state="passwordState"
        >
          <b-form-input
            ref="password-input"
            v-model="password"
            type="password"
            :state="passwordState"
            required
          ></b-form-input>
        </b-form-group>
        <b-form-group
          label="確認密碼"
          label-for="checkPassword-input"
          invalid-feedback="與密碼不同"
          :state="checkPasswordState"
        >
          <b-form-input
            ref="checkPassword-input"
            v-model="checkPassword"
            type="password"
            :state="checkPasswordState"
            required
          ></b-form-input>
        </b-form-group>
        </b-col>
        <b-col md='6'>
        <b-form-group
          label="電話號碼"
          label-for="phone-input"
          invalid-feedback="電話號碼錯誤"
          :state="phoneState"
        >
          <b-form-input
            ref="phone-input"
            v-model="phone"
            type="tel"
            :state="phoneState"
            required
          ></b-form-input>
        </b-form-group>
        <b-form-group
          label="電子信箱"
          label-for="email-input"
          invalid-feedback="電子信箱錯誤"
          :state="emailState"
        >
          <b-form-input
            ref="email-input"
            v-model="email"
            type="email"
            :state="emailState"
            required
          ></b-form-input>
        </b-form-group>
        <input type="file" accept="image/*" @change="previewImage" id="upload">
        <img :src="preview" @click="upload" class="preview"/>
        </b-col>
        </b-row>
      </form>
      <b-alert fade :show="showAlert" variant="danger">{{ errorMsg }}</b-alert>
      <div class="row m-2" style="justify-content:space-around">
          <b-button variant="info" @click="submit" size="sm">CONFIRM</b-button>
          <b-button variant="info" @click="$emit('close')" size="sm">CANCEL</b-button>
      </div>
    </b-modal>
  </div>
</template>

<script>
  export default {
    name: 'AddSellerForm',
    data() {
        return {
            name: null,
            username: null,
            password: null,
            checkPassword: null,
            phone:null,
            email:null,
            showAlert: false,
            image:null,
            preview: require('../assets/photoupload.png'),
            errorMsg: ''
        }
    },
    computed: {
      nameState() {
          if (this.name === null) {
              return null
          }
          return this.name.length > 0
      },
      usernameState() {
          if (this.username === null) {
              return null
          }
          return this.username.length > 0
      },
      passwordState() {
          if (this.password === null) {
              return null
          }
          return this.password.length > 0
      },
      checkPasswordState() {
          if (this.checkPassword === null) {
              return null
          }

          return this.checkPassword.length > 0 && this.checkPassword==this.password
      },
      phoneState() {
          if (this.phone === null) {
              return null
          }

          return this.phone.length == 10 && this.phone.substr(0,1) =='0'
      },
      emailState() {
          if (this.email === null) {
              return null
          }

          return this.email.length > 0 && this.email.indexOf("@") !=-1
      },
    },
    methods: {
        upload(){
            let upload=document.querySelector('#upload')
            upload.click()
        },
        previewImage: function(event) {
        var input = event.target;
        if (input.files) {
            var reader = new FileReader();
            reader.onload = (e) => {
            this.preview = e.target.result;
            }
            this.image=input.files[0];
            reader.readAsDataURL(input.files[0]);
        }
        },
      checkFormValidity() {
        const valid1 = this.$refs['name-input'].checkValidity()
        const valid2 = this.$refs['username-input'].checkValidity()
        const valid3 = this.$refs['password-input'].checkValidity()
        const valid4 = this.$refs['checkPassword-input'].checkValidity()
        const valid5 = this.$refs['phone-input'].checkValidity()
        const valid6 = this.$refs['email-input'].checkValidity()
        return valid1 && valid2 && valid3 && valid4 && valid5 && valid6
      },
      submit() {
        // Exit when the form isn't valid
        if (!this.checkFormValidity()) {
            this.name= null
            this.username= null
            this.password= null
            this.checkPassword= null
            this.phone=null
            this.email=null
            this.image=null
            return
        }

        this.$_verification(this.name, this.username, this.password, this.phone, this.email, this.image)
      },
      $_verification(name, username, password, phone, email, image) {
        let i={
          member:{
          name: name,
          username: username,
          password: password,
          phone: phone,
          email: email,
          member_status: 1,
          permission: 1},
          seller:{
              image: image
          }
        }
        console.log(i)
        return
        let url='/members/seller/add';
        this.$http.post(url, {
          member:{
          name: name,
          username: username,
          password: password,
          phone: phone,
          email: email,
          member_status: 1,
          permission: 1},
          seller:{
              image: image
          }
        })
        .then(response => {
          this.showAlert = false
          let data = response.data
          setTimeout(() => {
            this.$fire({
            title: "註冊成功",
            text: "Successfully logged in",
            type: "success",
            timer: 5000
          })
          }, 300)
          this.$emit('close')
        })
        .catch(error => {
          console.log(error)
          let status = error.response.status
          switch (status) {
            case 401:
              this.errorMsg = 'Invalid account or password';
              this.showAlert = true;
              break;
            case 500:
              this.errorMsg = 'Unknown error';  //FIXME
              this.showAlert = true;
              break;
          }
          this.account = null
          this.password = null
        })
      },
      reset() {
            this.name= null
            this.username= null
            this.password= null
            this.checkPassword= null
            this.phone=null
            this.email=null
            this.image=null
            this.preview= require('../assets/photoupload.png'),
            this.showAlert = false
      }
    }
  }
</script>

<style scoped>
#upload{
    display: none;
}
.preview{
    width: 100%;
    height: 160px;
}
</style>