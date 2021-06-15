<template>
  <b-form @submit.prevent="saveTask">
    <h1>Edit/Create task</h1>

    <b-form-group id="input-group-title">
      <b-form-input
        id="input-title"
        v-model="task.title"
        type="text"
        required
        placeholder="Title"
      ></b-form-input>
    </b-form-group>
    <b-form-group id="input-group-comment">
      <b-form-input
        id="input-comment"
        v-model="task.comment"
        type="text"
        required
        placeholder="Comment"
      ></b-form-input>
    </b-form-group>

    <b-form-group id="input-group-time-spend">
      <b-form-input
        id="input-time-spend"
        v-model="task.time_spend"
        type="number"
        placeholder="Time spend"
      ></b-form-input>
    </b-form-group>

    <b-form-group id="input-group-date">
      <b-form-datepicker
        id="input-date"
        v-model="task.date"
        required
        class="mb-2"
      ></b-form-datepicker>
    </b-form-group>

    <b-button type="submit" variant="dark">Save</b-button>
    <b-button type="button" variant="white">
      <router-link :to="{name:'home'}">Home</router-link>
    </b-button>
  </b-form>
</template>
<script>
export default {
  name: "CreateTaskForm",

  data() {
    return {
      task: {
        title: null,
        comment: null,
        time_spend: 0,
        date: null
      }
    };
  },

  methods: {
    async saveTask() {
      let action = 'createTask';
      let data = Object.assign({}, this.task);

      if (this.isEditPage()) {
        action = 'saveTask';
        data.id = this.$route.params.id;
      }

      delete data['user'];

      await this.$store
        .dispatch(action, data).then(res=> {
          if (res.data){
            this.task = Object.assign({}, this.task, res.data);
            if (!this.isEditPage()) {
              this.$router.push({ name:"task.edit", params: { id: res.data.id } })
            }
          }
        });
    },

    isEditPage(){
      return this.$route.name === 'task.edit';
    },

    async loadTask() {
      await this.$store
        .dispatch('loadTask', this.$route.params.id).then(res=> {
          if (res.data){
            this.task = Object.assign({}, this.task, res.data);
          }
        });
    }
  },
  created() {
    if (this.isEditPage()) {
      this.loadTask();
    }
  }
};
</script>
