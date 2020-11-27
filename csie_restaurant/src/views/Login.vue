<template>
  <div class="login">
    <center>
      <button class="btn btn-lg btn-info">Login</button>
      <HelloWorld msg='Welcome to Login Page' />
    </center>
  </div>
</template>


<script>
// @ is an alias to /src
import HelloWorld from "@/components/HelloWorld.vue";
export default {
  name: "login",
  components: {
    HelloWorld
  },
  data: function() {
    return {};
  },
  methods: {}
};
</script>