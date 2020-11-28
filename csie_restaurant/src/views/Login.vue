<template>
    <div >
      <FoodCardGroup  />
    </div>
</template>


<script>
// @ is an alias to /src
import FoodCardGroup from "@/components/FoodCardGroup.vue";
export default {
  name: "login",
  components: {
    FoodCardGroup
  },
  data: function() {
    return {};
  },
  methods: {}
};
</script>