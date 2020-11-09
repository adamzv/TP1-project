import Vue from "vue";
import Vuex from "vuex";
import httpClient from "./httpClient.js";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    token: localStorage.getItem("access_token") || null
    // user: localStorage.getItem("user") || null
  },
  getters: {
    loggedIn(state) {
      return state.token !== null;
    }
    // loggedInName(state) {
    //   return state.user.name + " " + state.user.surname;
    // }
  },
  mutations: {
    retrieveToken(state, token) {
      state.token = token;
    },
    retrieveUser(state, user) {
      state.user = user;
    },
    destroyToken(state) {
      state.token = null;
    }
  },
  actions: {
    retrieveToken(context, credentials) {
      return new Promise((resolve, reject) => {
        httpClient
          .post("/users/login", {
            email: credentials.email,
            password: credentials.password
          })
          .then(response => {
            const token = response.data.access_token;
            // const user = response.data.user;

            localStorage.setItem("access_token", token);
            // localStorage.setItem("user", user);
            context.commit("retrieveToken", token);
            // context.commit("retrieveUser", user);
            resolve(response);
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
              localStorage.removeItem("access_token");
              context.commit("destroyToken");
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
            reject(error);
          });
      });
    }
    // retrieveUserData(context) {
    //   return new Promise((resolve, reject) => {
    //     httpClient
    //       .post("/users/login", {
    //         email: credentials.email,
    //         password: credentials.password
    //       })
    //       .then(response => {
    //         const token = response.data.access_token;
    //         const user = response.data.user;

    //         localStorage.setItem("access_token", token);
    //         localStorage.setItem("user", user);
    //         context.commit("retrieveToken", token);
    //         context.commit("retrieveUser", user);
    //         resolve(response);
    //       })
    //       .catch(error => {
    //         reject(error);
    //       });
    //   });
    // }
  }
});
