import Vue from "vue";
import Vuex from "vuex";
import httpClient from "./httpClient.js";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    token: localStorage.getItem("access_token") || null,
    userId: null,
    user: null,
    newEventSubmitted: false,
    carouselHeight: 500,
    loading: [],
    fileUploadLoading: false
  },
  getters: {
    fileUploadLoading(state) {
      return state.fileUploadLoading;
    },
    token(state) {
      return state.token;
    },
    loading(state) {
      return state.loading;
    },
    loggedIn(state) {
      return state.token !== null;
    },
    loggedInId(state) {
      return state.userId || null;
    },
    loggedInUser(state) {
      return state.user || null;
    },
    loggedInName(state) {
      return state.user !== null
        ? state.user.name + " " + state.user.surname
        : null;
    },
    permissionToAddEvents(state) {
      return (
        state.user !== null &&
        (state.user.id_role === 1 || state.user.id_role === 2)
      );
    },
    newEventSubmitted(state) {
      return state.newEventSubmitted;
    }
  },
  mutations: {
    updateLoading(state) {
      state.fileUploadLoading = !state.fileUploadLoading;
    },
    pushToLoading(state, component) {
      state.loading.push(component);
    },
    finishLoading(state, component) {
      state.loading.splice(state.loading.indexOf(component), 1);
    },
    changeCarouselHeight(state, payload) {
      state.carouselHeight = payload;
    },
    retrieveToken(state, token) {
      state.token = token;
    },
    retrieveUserId(state, userId) {
      state.userId = userId;
    },
    retrieveUser(state, user) {
      state.user = user;
    },
    destroyToken(state) {
      state.token = null;
    },
    destroyUser(state) {
      state.userId = null;
      state.user = null;
    },
    retrieveUserIdFromStorage(state) {
      state.userId = localStorage.getItem("id") || null;
    },
    submitNewEvent(state, change) {
      state.newEventSubmitted = change;
    }
  },
  actions: {
    updateLoading(context) {
      context.commit("updateLoading");
    },
    retrieveToken(context, credentials) {
      // and userId
      return new Promise((resolve, reject) => {
        httpClient
          .post("/users/login", {
            email: credentials.email,
            password: credentials.password
          })
          .then(response => {
            if (response.data.success) {
              const token = response.data.access_token;
              const userId = response.data.user.id;
              const user = response.data.user;

              localStorage.setItem("access_token", token);
              localStorage.setItem("id", userId);
              // localStorage.setItem("user", user);
              context.commit("retrieveToken", token);
              context.commit("retrieveUserId", userId);
              context.commit("retrieveUser", user);
              resolve(response);
            } else {
              reject(response);
            }
          })
          .catch(error => {
            reject(error);
          });
      });
    },
    destroyToken(context) {
      httpClient.defaults.headers.common["Authorization"] =
        "Bearer " + context.state.token;

      if (context.getters.loggedIn) {
        return new Promise((resolve, reject) => {
          httpClient
            .get("/users/logout")
            .then(response => {
              // removes token
              localStorage.removeItem("access_token");
              context.commit("destroyToken");

              // removes user
              localStorage.removeItem("id");
              context.commit("destroyUser");
              resolve(response);
            })
            .catch(error => {
              localStorage.removeItem("access_token");
              context.commit("destroyToken");
              reject(error);
            });
        });
      }
    },
    register(context, data) {
      return new Promise((resolve, reject) => {
        httpClient
          .post("/users/register", {
            name: data.name,
            surname: data.surname,
            email: data.email,
            password: data.password,
            id_role: 3
          })
          .then(response => {
            resolve(response);
          })
          .catch(error => {
            reject(error.response);
          });
      });
    },
    retrieveUserData(context) {
      httpClient.defaults.headers.common["Authorization"] =
        "Bearer " + context.state.token;
      if (context.getters.loggedInId) {
        return new Promise((resolve, reject) => {
          httpClient
            .get(`/users/${context.state.userId}`)
            .then(response => {
              const user = response.data;

              context.commit("retrieveUser", user);
              resolve(response);
            })
            .catch(error => {
              reject(error);
            });
        });
      }
    }
  }
});
