import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import "./bootstrap";
import Axios from "./axios";
import errorHandler from "./services/errorHandler";

import "./assets/app.scss";

Vue.config.productionTip = false;

Vue.prototype.$http = Axios();
errorHandler(Vue.prototype.$http, store, router);

const token = store.getters.getToken;

if (token) {
  Vue.prototype.$http.defaults.headers.common["Authorization"] =
    "Bearer " + token;
}

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount("#app");
