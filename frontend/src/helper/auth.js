import Vue from "vue";

const setTokens = (commit, token, refreshToken) => {
  localStorage.setItem("token", token);
  localStorage.setItem("refresh_token", refreshToken);
  commit("setToken", token);
  commit("setRefreshToken", refreshToken);
};

const removeTokens = commit => {
  localStorage.removeItem("token");
  localStorage.removeItem("refresh_token");
  commit("setToken", null);
  commit("setRefreshToken", null);
};

const updateAuthorizationHeader = token => {
  Vue.prototype.$http.defaults.headers.common["Authorization"] = token;
};

export const jwtDecode = require("jwt-decode");

export const clearAuthorization = commit => {
  commit("setUser", {});
  removeTokens(commit);
  updateAuthorizationHeader("");
};

export const authorize = (commit, token, refreshToken) => {
  const user = jwtDecode(token);
  setTokens(commit, token, refreshToken);
  updateAuthorizationHeader("Bearer " + token);
  commit("setUser", user);
};

export const hasRole = (state, role) => {
  return !!(Object.keys(state.user).length && state.user.roles.includes(role));
};
