<template>
  <div>
    <b-table  
    :items="items" 
    :fields="fields" 
    :head-variant="headvariant"
    :table-variant="teblevariant"
    :striped="stripped"
    :hover="hover"
    :outlined="outlined"
    :borderless="borderless"
    >
    <template #cell(function)>
        <b-button size="sm" class="mr-2"> Details </b-button>
        <b-button size="sm" class="mr-2"> Details </b-button>
    </template>
    </b-table>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        // Note 'isActive' is left out and will not appear in the rendered table
        fields: [
          {
            key: 'id',
            label: '編號',
          },
          {
            key: 'username',
            label: '客戶帳號',
          },
          {
            key: 'name',
            label: '客戶暱稱',
            // Variant applies to the whole column, including the header and footer
          },
          {
            key: 'email',
            label: '客戶信箱',
            // Variant applies to the whole column, including the header and footer
          },
          {
            key: 'created_at',
            label: '註冊時間',
            // Variant applies to the whole column, including the header and footer
          },
          {
            key: 'phone',
            label: '電話號碼',
            // Variant applies to the whole column, including the header and footer
          },
          {
            key: 'member_status',
            label: '狀態',
            // Variant applies to the whole column, including the header and footer
          },
          {
            key: 'function',
            label: '操作',
            // Variant applies to the whole column, including the header and footer
          }
        ],
        items: [
          { isActive: true, id: 1, username: 'asd3013593', name: '夏先生', email:'t107590001@gmail.com', created_at:'2000-02-30', phone:'0934426548', member_status:'O', },
          { isActive: true, id: 2, username: 'asd3013593', name: '夏先生', email:'t107590001@gmail.com', created_at:'2000-02-30', phone:'0934426548', member_status:'O', },
          { isActive: true, id: 3, username: 'asd3013593', name: '夏先生', email:'t107590001@gmail.com', created_at:'2000-02-30', phone:'0934426548', member_status:'O', },
          { isActive: true, id: 4, username: 'asd3013593', name: '夏先生', email:'t107590001@gmail.com', created_at:'2000-02-30', phone:'0934426548', member_status:'O', },
        ],
        headvariant:"dark",
        tablevariant:'',
        striped:false,
        hover:true,
        outlined:true,
        borderless:false,
      }
    }
  }
</script>

<style scoped>

</style>