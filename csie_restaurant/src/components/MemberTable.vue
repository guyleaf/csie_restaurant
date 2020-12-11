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
            key: 'last_name',
            sortable: true
          },
          {
            key: 'first_name',
            sortable: false
          },
          {
            key: 'age',
            label: 'Person age',
            sortable: true,
            // Variant applies to the whole column, including the header and footer
          }
        ],
        items: [
          { isActive: true, age: 40, first_name: 'Dickerson', last_name: 'Macdonald' },
          { isActive: false, age: 21, first_name: 'Larsen', last_name: 'Shaw' },
          { isActive: false, age: 89, first_name: 'Geneva', last_name: 'Wilson' },
          { isActive: true, age: 38, first_name: 'Jami', last_name: 'Carney' }
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