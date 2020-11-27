<template>
  <div class="home">
    <center>
      <Search />
      <CardGroup />
    </center>
  </div>
</template>

<script>
// @ is an alias to /src
import Search from "@/components/Search.vue";
import CardGroup from "@/components/CardGroup.vue";
export default {
  name: "home",
  components: {
    Search,
    CardGroup
  }
};
</script>