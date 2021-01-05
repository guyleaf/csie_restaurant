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

    <div class="col-4">
      <h3>調整類別順序</h3>

      <draggable
        :list="list"
        :disabled="!enabled"
        class="list-group list-group-horizontal"
        ghost-class="ghost"
        :move="checkMove"
        @start="dragging = true"
        @end="dragEnd"
      >
        <div
          class="list-group-item"
          v-for="element in list"
          :key="element.foodCategory"
          
        >
          {{ element.foodCategory }}
        </div>
      </draggable>
    </div>

    <rawDisplayer class="col-3" :value="list" title="List" />
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
      orgin:[],
      dragging: false
    };
  },
  computed: {
  },
  methods: {
    add: function() {
      this.list.push({ foodCategory: "Ron " + order, order: order++ });
    },
    finish: function(){
        this.$bus.$emit('updateTab',this.list);
    },
    checkMove: function(e) {
        window.console.log("Dragging:" + e.draggedContext.index + " Future index: " + e.draggedContext.futureIndex);
        
    },
    dragEnd: function(e) {
        for(let i=0;i<this.foodCategory.length;i++){
            this.list[i].order = i;
            console.log('now:',this.list[i].foodCategory,this.list[i].order);
        }
    }
  },
  created(){
    for(let i=0;i<this.foodCategory.length;i++)
        this.list.push({foodCategory:this.foodCategory[i].foodCategory, order:this.foodCategory[i].order});
        this.orgin.push({foodCategory:this.foodCategory[i].foodCategory, order:this.foodCategory[i].order});
        order += 1;
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
</style>