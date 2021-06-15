<template>
  <b-row class="justify-content-md-center">
    <b-col cols="12" md="6" lg="4">
      <create-task-form />
    </b-col>
  </b-row>
</template>

<script>
import CreateTaskForm from "../components/CreateTaskForm";

export default {
  name: "CreateTask",

  components: {
    CreateTaskForm,
  }
};
</script>
