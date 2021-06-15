<template>
  <div>
    <b-table hover :fields="fields" :items="getTasks">
      <template #cell(actions)="row">
        <router-link :to="{name:'task.edit', params: {id:row.item.id}}">Edit</router-link>
        <br/>
        <a href="#" @click="deleteTask(row.item.id)">Delete</a>
      </template>
    </b-table>
    <b-button type="submit" variant="dark">
      <router-link :to="{name: 'task.add'}">Add task</router-link>
    </b-button>
  </div>
</template>
<script>
import { mapGetters } from 'vuex';
export default {
  name: "TasksTableComponent",

  computed: {
    ...mapGetters([
      'getTasks',
    ]),
  },

  data() {
    return {
      fields: [
        { key: 'id', label: 'ID'},
        { key: 'title', label: 'Title'},
        { key: 'comment', label: 'Comment'},
        { key: 'time_spend', label: 'Spend time (m)'},
        { key: 'date', label: 'Date'},
        { key: 'actions', label : 'Actions'}
      ]
    }
  },

  methods: {
    async loadTasks() {
      await this.$store.dispatch("loadTasks");
    },
    deleteTask(id) {
     this.$store.dispatch("deleteTask", id);
    }
  },

  mounted() {
    this.loadTasks();
  }
};
</script>
