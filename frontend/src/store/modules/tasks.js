import Vue from "vue";

export default {
  state: {
    tasks: [],
    task: null
  },
  mutations: {
    setTasks: (state, payload) => (state.tasks = payload),
    setTask: (state, payload) => (state.task = payload)
  },
  getters: {
    getTasks: state => state.tasks,
    getTask: state => state.task
  },
  actions: {
    loadTasks({ commit }) {
      return new Promise((resolve, reject) => {
        Vue.prototype.$http
          .get("task")
          .then(response => {
            commit("setTasks", response.data);
            resolve(response);
          })
          .catch(error => {
            reject(error);
          });
      });
    },
    loadTask({ commit }, id) {
      return new Promise((resolve, reject) => {
        Vue.prototype.$http
          .get("task/show/" + id)
          .then(response => {
            commit("setTask", response.data);
            resolve(response);
          })
          .catch(error => {
            reject(error);
          });
      });
    },
    saveTask({ commit }, data) {
      return new Promise((resolve, reject) => {
        Vue.prototype.$http
          .put("task/edit/" + data.id, data)
          .then(response => {
            commit("setTask", response.data);
            resolve(response);
          })
          .catch(error => {
            reject(error);
          });
      });
    },
    createTask({ commit }, data) {
      return new Promise((resolve, reject) => {
        Vue.prototype.$http
          .post("task/new", data)
          .then(response => {
            commit("setTask", response.data);
            resolve(response);
          })
          .catch(error => {
            reject(error);
          });
      });
    },
    deleteTask({ dispatch }, id) {
      return new Promise((resolve, reject) => {
        Vue.prototype.$http
          .delete("task/remove/" + id)
          .then(response => {
            dispatch("loadTasks");
            resolve(response);
          })
          .catch(error => {
            reject(error);
          });
      });
    }
  }
};
