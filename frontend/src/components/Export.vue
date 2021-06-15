<template>
  <b-button v-on:click="exportTasks" type="button" variant="dark">
    Export
  </b-button>
</template>

<script>
export default {
  name: "Export",
  methods: {
    exportTasks() {
      console.log(1);
      this.$http
        .get("task/exportcsv", { responseType: "blob" })
        .then((response) => {
          const url = window.URL.createObjectURL(new Blob([response.data]));
          const link = document.createElement("a");
          link.href = url;
          link.setAttribute("download", "tasks.csv");
          document.body.appendChild(link);
          link.click();
      }).catch((errors) => {
        console.log(errors)
      });
    }
  }
}
</script>
