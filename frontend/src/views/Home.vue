<template>
  <div class="home">
    <TasksTableComponent></TasksTableComponent>
    <br>
    <export></export>
  </div>
</template>

<script>

import TasksTableComponent from "../components/TasksTableComponent";
import Export from "../components/Export";
export default {
  name: "Home",
  components: {
    Export,
    TasksTableComponent,
  }
};
</script>
