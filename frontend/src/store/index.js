import Vue from "vue";
import Vuex from "vuex";
import auth from "./modules/auth";
import tasks from "./modules/tasks";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    loading: false
  },
  getters: {
    getLoading: state => state.loading
  },
  mutations: {
    setLoading: (state, payload) => (state.loading = payload)
  },
  modules: {
    auth,
    tasks
  },
  strict: true
});
