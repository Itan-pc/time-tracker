<template>
  <b-row class="justify-content-md-center">
    <b-col cols="12" id="nav">
      <router-link :to="{ name:'login' }">Login</router-link> |
      <router-link :to="{ name:'register' }">Register</router-link>
    </b-col>
    <b-col cols="12" md="6" lg="4">
      <register-form />
    </b-col>
  </b-row>
</template>

<script>
import RegisterForm from "../components/RegisterForm";

export default {
  name: "Register",

  components: {
    RegisterForm
  }
};
</script>
