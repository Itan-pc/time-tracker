<template>
  <b-form @submit.prevent="register">
    <h1>Register</h1>

    <b-form-group id="input-group-username">
      <b-form-input
        id="input-email"
        v-model="email"
        type="email"
        required
        placeholder="Email"
      ></b-form-input>
    </b-form-group>

    <b-form-group id="input-group-password">
      <b-form-input
        id="input-password"
        v-model="password"
        type="password"
        required
        placeholder="Password"
      ></b-form-input>
    </b-form-group>

    <b-button type="submit" variant="dark">Register</b-button>
  </b-form>
</template>
<script>
export default {
  name: "RegisterForm",

  data() {
    return {
      email: null,
      password: null
    };
  },

  methods: {
    async register() {
      const { email, password } = this;
      await this.$store
        .dispatch("register", { email, password })
        .then(() => this.$router.push("/"));
    }
  }
};
</script>
