<template>
  <div>
    <b-table  
      :items="members" 
      :fields="fields" 
      :head-variant="headvariant"
      :table-variant="teblevariant"
      :striped="stripped"
      :hover="hover"
      :outlined="outlined"
      :borderless="borderless"
      >
      <template #cell(member_status)="row">
        <img v-if="row.item.member_status==0" :src="onImage" @click="changestatus(row)"/>
        <img v-else :src="noImage" @click="changestatus(row)"/>
      </template>
      <template #cell(function)="row">
        <img :src="deleteImage" @click="deleteMember(row)"/>
      </template>
    </b-table>
    <div>
      <button id='lstPg' @click="routeMembers('last')" disabled='disabled' >上一頁</button>
      <button id='nxtPg' @click="routeMembers('next')">下一頁</button>
    </div>
  </div>
  
</template>

<script>
  export default {
    name: "MemberTable",
    data() {
      return {
        deleteImage:require('../assets/xIcon.png'),
        noImage:require('../assets/red.png'),
        onImage:require('../assets/green.png'),
        members:[],
        currentNumber: 0,
        requiredNumber: 5,
        numOfMembers: 0,
        // Note 'isActive' is left out and will not appear in the rendered table
        fields: [
          {
            key: 'id',
            label: '編號',
            class:'tdId text-center',
            tdClass: 'tdId'
          },
          {
            key: 'username',
            label: '客戶帳號',
            class:'tdUserName text-center',
            tdClass: 'tdUserName'
          },
          {
            key: 'name',
            label: '客戶暱稱',
            class:'tdName text-center',
            tdClass: 'tdName'
            // Variant applies to the whole column, including the header and footer
          },
          {
            key: 'email',
            label: '客戶信箱',
            class:'tdemail text-center',
            tdClass: 'tdemail'
            // Variant applies to the whole column, including the header and footer
          },
          {
            key: 'created_at',
            label: '註冊時間',
            class: 'text-center'
            // Variant applies to the whole column, including the header and footer
          },
          {
            key: 'phone',
            label: '電話號碼',
            class: 'text-center'
            // Variant applies to the whole column, including the header and footer
          },
          {
            key: 'member_status',
            label: '狀態',
            class: 'text-center'
            // Variant applies to the whole column, including the header and footer
          },
          {
            key: 'function',
            label: '操作',
            class: 'text-center'
            // Variant applies to the whole column, including the header and footer
          }
        ],
        headvariant:"dark",
        teblevariant:'',
        stripped:false,
        hover:true,
        outlined:true,
        borderless:false,
      }
    },
    methods:{
      changestatus(member){
        if(!this.members[member.index].member_status) var msg = "你確定要停用這位會員？"
        if(this.members[member.index].member_status) var msg = "你確定要開啟這位會員？"
        this.$confirm(msg,"","question").then(() => {
            let update = {id:this.members[member.index].id, member_status:!this.members[member.index].member_status}
            this.$http.post('/admin/members/update',update,{
                headers: {
                'Authorization': 'Bearer ' + this.$store.getters['auth/token'],
                }
            }).then(response =>{
                this.$alert("修改成功","","success");
                this.members[member.index].member_status=!this.members[member.index].member_status
            }).catch(error=>{
                this.$alert("修改失敗","","error");
                console.log(error.response)
            })
        });    
      },
      deleteMember(member){
        this.$confirm("你確定要刪除？","","question").then(() => {
            let deleteMember = {id:this.members[member.index].id}
            this.$http.post('/admin/members/delete',deleteMember,{
                headers: {
                'Authorization': 'Bearer ' + this.$store.getters['auth/token'],
                }
            }).then(response =>{
                this.$alert("刪除成功","","success");
                this.members.splice(member.index,1);
                console.log("刪除成功")
                this.routeMembers("now")
                this.$emit("deleteMember")
            })
            .catch(error=>{
                this.$alert("刪除失敗","","error");
                console.log(error.response)
            })
        });
      },
      routeMembers(direction){
        this.members = []
        if (direction == 'next')  {this.currentNumber += this.requiredNumber}
        else if(direction == 'last') {this.currentNumber -= this.requiredNumber}
        let url  = '/admin/customers?' + 'currentNumber=' + this.currentNumber.toString() + '&' + 'requiredNumber=' + this.requiredNumber.toString()
        this.$http.get(url)
        .then(response => {
        this.members = [];
        let data = response.data.customers;
        for (let i=0;i<data.length;i++){ this.members.push({isActive:true, id:data[i].customer_id, username:data[i].username, name:data[i].name, email:data[i].email, 
                                                            created_at:data[i].created_at, phone:data[i].phone, member_status:data[i].member_status})}
        })
        this.checkRoute()
      },
      checkRoute(){
        let lstPgButton = document.getElementById("lstPg")
        let nxtButton = document.getElementById('nxtPg')
        let nxtNumber = this.currentNumber + this.requiredNumber
        if (this.currentNumber == 0) {lstPgButton.disabled = true;}
        else {lstPgButton.disabled = false;}
        if (nxtNumber >= this.numOfMembers) {nxtButton.disabled = true}
        else {nxtButton.disabled = false}
        console.log(this.currentNumber );
      },
      refresh() {
        let url = '/admin/customers?currentNumber=0&requiredNumber=5'
        this.$axios.get(this.$url + url)
        .then(response => {
          this.members = [];
          let data = response.data.customers;
          for (let i=0;i<data.length;i++){ this.members.push({isActive:true, id:data[i].customer_id, username:data[i].username, name:data[i].name, email:data[i].email, 
                                                              created_at:data[i].created_at, phone:data[i].phone ,member_status:data[i].member_status})}
          this.numOfMembers = response.data.numbers;
          this.$bus.$emit('setNumOfMembers', this.numOfMembers);
        })
      }
    },
    mounted () {
      this.refresh();
    },
  }
</script>

<style scoped>
  ::v-deep .tdId{
    width: 6%;
  }
  ::v-deep .tdUserName{
    width: 15%;  
  }
  ::v-deep .tdName{
    width: 15%;
  }
  ::v-deep .tdemail{
    width: 20%;
  }
</style>