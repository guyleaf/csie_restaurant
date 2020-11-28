<template>
    <div >
      <HelloWorld msg="WELCOME TO SHOP PAGE"/>
    </div>
</template>


<script>
// @ is an alias to /src
import HelloWorld from "@/components/HelloWorld.vue";
export default {
  name: "Shop",
  components: {
    HelloWorld
  },
  data: function() {
    return {};
  },
  methods: {}
};
</script>