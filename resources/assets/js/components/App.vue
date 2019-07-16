<template>
  <div id="app">
    <div class="heading">
      <h1>Cruds</h1>
    </div>
    <crud-component
      v-for="crud in cruds"
      v-bind="crud"
      :key="crud.id"
      @update="update"
      @delete="del"
    ></crud-component>
    <div>
      <button @click="create()">Add</button>
    </div>
  </div>
</template>
<script>
  function Crud({ id, color, name}) {
    this.id = id;
    this.color = color;
    this.name = name;
  }

  import CrudComponent from './CrudComponent.vue';

  export default {
    data() {
      return {
        cruds: [],
        mute: false
      }
    },
    methods: {
      read() {
        window.axios.get('/api/cruds').then(({ data }) => {
          data.forEach(crud => {
            this.cruds.push(new Crud(crud));
          });
        });
      },
      update(id, color) {
        this.mute = true;
        window.axios.put(`/api/cruds/${id}`, { color }).then(() => {
          // 一旦请求成功，就更新 Crud 的颜色
          this.cruds.find(crud => crud.id === id).color = color;
          this.mute = false;
        });
      },
      create() {
        window.axios.get('/api/cruds/create').then(({ data }) => {
          this.cruds.push(new Crud(data));
        });
      },
      del(id) {
        window.axios.delete(`/api/cruds/${id}`).then(() => {
          let index = this.cruds.findIndex(crud => crud.id === id);
          this.cruds.splice(index, 1);
        });
      }
    },
    components: {
      CrudComponent
    },
    watch: {
      mute(val) {
        document.getElementById('mute').className = val ? "on" : "";
      }
    }
  }
</script>