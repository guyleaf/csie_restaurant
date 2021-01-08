<template>
  <div class="row">
    <div class="col-2">
      <div class="form-group">
        <div
          class="btn-group-vertical buttons"
          role="group"
          aria-label="Basic example"
        >
          <button class="btn btn-secondary" @click="add" :disabled="!enabled">Add</button>
          <button class="btn btn-secondary" @click="finish" :disabled="!enabled">Confirm</button>
        </div>

        <div class="form-check">
          <input
            id="disabled"
            type="checkbox"
            v-model="enabled"
            class="form-check-input"
          />
          <label class="form-check-label" for="disabled">啟用編輯</label>
        </div>
      </div>
    </div>

    <div class="scrollbar col-10">
      <h3>調整類別順序</h3>

      <draggable
        :list="list"
        :disabled="!enabled"
        class="list-group list-group-horizontal row"
        ghost-class="ghost"
        :move="checkMove"
        @start="dragging = true"
        @end="dragEnd"
      >
        <div
          class="list-group-item col-2"
          v-for="element in list"
          :key="element.foodCategory"
        >
          {{ element.foodCategory }}
        </div>
      </draggable>
    </div>
  </div>
</template>

<script>
import draggable from "vuedraggable";
let order = 0;
export default {
  name: "DraggableTab",
  order: 0,
  components: {
    draggable
  },
  props:{
      foodCategory: Array
  },
  data() {
    return {
      enabled: true,
      list: [],
      dragging: false
    };
  },
  computed: {
  },
  watch:{
    foodCategory: function(){
      this.list=[]
      for(let i=0;i<this.foodCategory.length;i++){
        this.list.push({foodCategory:this.foodCategory[i].foodCategory, order:this.foodCategory[i].order});
        order += 1;
    }}
  },
  methods: {
    add: function() {
      let name="新類別"
      let i=1
      while(this.list.find(list=> list.foodCategory==name))
      {
        name="新類別"+i.toString()
        i++
      }
      this.list.push({ foodCategory: name, order: order++ });
    },
    finish: function(){
        this.$bus.$emit('updateTab',this.list);
    },
    checkMove: function(e) {
    },
    dragEnd: function(e) {
        for(let i=0;i<this.foodCategory.length;i++){
            this.list[i].order = i;
        }
    }
  },
  created(){
    for(let i=0;i<this.foodCategory.length;i++){
        this.list.push({foodCategory:this.foodCategory[i].foodCategory, order:this.foodCategory[i].order});
        order += 1;
    }
  },

};
</script>
<style scoped>
.buttons {
  margin-top: 35px;
}
.ghost {
  opacity: 0.5;
  background: #c8ebfb;
}
.scrollbar{
  overflow-x: auto;
  overflow-y: hidden;
}
</style>