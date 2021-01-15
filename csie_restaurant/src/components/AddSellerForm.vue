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
        <b-form-group
          label="櫃位號碼"
          label-for="counter-input"
          invalid-feedback="櫃位號碼錯誤"
          :state="counterState"
        >
          <b-form-input
            ref="counter-input"
            v-model="counter_number"
            type="number"
            :state="counterState"
            required
          ></b-form-input>
        </b-form-group>
          <b-form-group
          label="標籤"
          label-for="category-input"
          invalid-feedback="請選擇至少一商店分類"
          :state="categoryState"
          >
          <b-form-select v-model="selected" :options="categories" multiple :select-size="8" :state="categoryState"></b-form-select>
        </b-form-group>
        </b-col>
        </b-row>
        <div class="row">
          <div class='desField col-6'>
              <div class='desStyle'>
                  <b-form-textarea
                      no-resize
                      id="textarea-plaintext"
                      placeholder="商店敘述"
                      style="height:100%; width:100%"
                      debounce="500"
                      v-model="description"
                  />
              </div>
          </div>
          <div class="col">
            <input type="file" accept="image/*" @change="previewImage" id="upload">
            <img :src="preview" @click="upload" class="preview"/>
          </div>
        </div>
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
import { serialize } from 'object-to-formdata';
  export default {
    name: 'AddSellerForm',
    data() {
        return {
            selected: [],
            name: null,
            username: null,
            password: null,
            checkPassword: null,
            phone:null,
            email:null,
            showAlert: false,
            image:null,
            counter_number:null,
            description:'',
            categories:[],
            preview: require('../assets/photoupload.png'),
            errorMsg: ''
        }
    },
    computed: {
      categoryState() {
        return this.selected.length > 0
      },
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
      counterState(){
          if (this.counter_number === null) {
              return null
          }

          return this.counter_number.length > 0 && this.counter_number>0
      }
    },
    methods: {
        showModal(){
            this.$refs['my-modal'].show();
        },
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
            // console.log("錯誤")
            return
        }
        this.$_verification(this.name, this.username, this.password, this.phone, this.email, this.image, this.counter_number, this.description)
      },
      $_verification(name, username, password, phone, email, image, counter_number, description) {
        let seller={counter_number:parseInt(counter_number), description:description}
        const data = {
        member:{
          name: name,
          username: username,
          password: password,
          phone: phone,
          email: email,
          member_status: 0,
          permission: 1},
        seller:{
            counter_number:parseInt(counter_number),
            description:description,
            header_image:image
        }};
        const formData = serialize(data)
        // console.log(data)
        let url='/admin/members/add';
        // console.log(data)
        this.$axios.post(this.$url + url, formData)
        .then(response => {
          this.showAlert = false
          let data = response.data
          // console.log(response.data)
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
          // console.log(error.response)
          let status = error.response.status
          switch (status) {
            case 401:
              this.errorMsg = 'Invalid account or password';
              this.showAlert = true;
              break;
            case 500:
              this.errorMsg = 'Server error';  //FIXME
              this.showAlert = true;
              break;
            case 400:
              this.errorMsg = error.response.data.message;
              this.showAlert = true;
              break;
          }
          this.password = null
          this.checkPassword = null
          this.counter_number = null
          this.selected = []
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
            this.description=''
            this.counter_number=null
            this.preview= require('../assets/photoupload.png'),
            this.showAlert = false
      }
    },
    created(){
    this.$http.get('/restaurants/category')
    .then(response => {
      // console.log(response.data)
      for(let i=0;i<response.data.length;i++)
      this.categories.push({text:response.data[i].name,value:response.data[i].category_id})
    })
    }
  }
</script>

<style scoped>
#upload{
    display: none;
}
.preview{
    width: 100%;
    height: 250px;
}
.desField{
    overflow-x: visible;
    overflow-y: scroll;
    padding:  1%;
    margin:0% 2% 3% 0;
    border-width: 2px;
    border-color: #000000;
    height: 250px;
}
.desStyle{
    line-height: 1.25rem;
    font-family: Arial, Helvetica, sans-serif;
    font-size: .675rem;
    height: 100%;
}
</style>