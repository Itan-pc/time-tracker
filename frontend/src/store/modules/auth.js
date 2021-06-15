import Vue from "vue";
import {
  authorize,
  clearAuthorization,
  jwtDecode,
  hasRole
} from "../../helper/auth";

const ROLE_ADMIN = "ROLE_ADMIN";
const ROLE_USER = "ROLE_USER";

export default {
  state: {
    token: localStorage.getItem("token") || null,
    refreshToken: localStorage.getItem("refresh_token") || null,
    user: localStorage.getItem("token")
      ? jwtDecode(localStorage.getItem("token"))
      : {}
  },
  mutations: {
    setToken: (state, payload) => (state.token = payload),
    setRefreshToken: (state, payload) => (state.refreshToken = payload),
    setUser: (state, payload) => (state.user = payload)
  },
  getters: {
    getToken: state => state.token,
    getRefreshToken: state => state.refreshToken,
    getUser: state => state.user,
    auth: state => {
      return {
        isAuthorized: !!Object.keys(state.user).length,
        isAdmin: hasRole(state, ROLE_ADMIN),
        isUser: hasRole(state, ROLE_USER)
      };
    }
  },
  actions: {
    login({ commit }, user) {
      return new Promise((resolve, reject) => {
        Vue.prototype.$http
          .post("login_check", user)
          .then(response => {
            const token = response.data.token;
            const refreshToken = response.data.refresh_token;
            authorize(commit, token, refreshToken);
            resolve(response);
          })
          .catch(error => {
            clearAuthorization(commit);
            reject(error);
          });
      });
    },
    register({ commit }, user) {
      return new Promise((resolve, reject) => {
        Vue.prototype.$http
          .post("token/create", user)
          .then(response => {
            const token = response.data.token;
            const refreshToken = response.data.refresh_token;
            authorize(commit, token, refreshToken);
            resolve(response);
          })
          .catch(error => {
            clearAuthorization(commit);
            reject(error);
          });
      });
    },
    logout({ commit }) {
      return new Promise(resolve => {
        clearAuthorization(commit);
        resolve();
      });
    },
    refreshToken({ commit, dispatch, state }) {
      return new Promise((resolve, reject) => {
        Vue.prototype.$http
          .post(
            "token/refresh",
            {
              refresh_token: state.refreshToken
            },
            {
              errorHandle: false
            }
          )
          .then(response => {
            const token = response.data.token;
            const refreshToken = response.data.refresh_token;
            authorize(commit, token, refreshToken);
            resolve(response);
          })
          .catch(error => {
            dispatch("logout");
            reject(error);
          });
      });
    }
  }
};
