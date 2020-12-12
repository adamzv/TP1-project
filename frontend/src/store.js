import Vue from "vue";
import Vuex from "vuex";
import httpClient from "./httpClient.js";
import jwt_decode from "jwt-decode";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    token: localStorage.getItem("access_token") || null,
    userId: null,
    user: null,
    newEventSubmitted: false,
    carouselHeight: 500,
    loading: [],
    fileUploadLoading: false,
    allowFiltering: false,
    currentlyInFilter: Object,
    filterEventName: "",
    filterBeginning: Date,
    filterCategories: [],
    filterFaculty: "",
    filterDepartment: "",
    filterPlace: "",

    URL_API_FILTER: `/events`
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
    },
    getAllowFiltering(state) {
      return state.allowFiltering;
    },
    getCurrentlyInFilter(state) {
      return state.currentlyInFilter;
    },
    getURL_API_FILTER(state) {
      return state.URL_API_FILTER;
    },
    getFilterEventName(state) {
      return state.filterEventName;
    },
    getFilterBeginning(state) {
      return state.filterBeginning;
    },
    getFilterCategories(state) {
      return state.filterCategories;
    },
    getFilterFaculty(state) {
      return state.filterFaculty;
    },
    getFilterDepartment(state) {
      return state.filterDepartment;
    },
    getFilterPlace(state) {
      return state.filterPlace;
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
    },
    setAllowFiltering(state, change) {
      state.allowFiltering = change;
    },
    setCurrentlyInFilter(state, change) {
      state.currentlyInFilter = change;
    },
    setURL_API_FILTER(state, change) {
      state.URL_API_FILTER = change;
    },
    setFilterEventName(state, change) {
      state.filterEventName = change;
    },
    setFilterBeginning(state, change) {
      state.filterBeginning = change;
    },
    setFilterCategories(state, change) {
      state.filterCategories = change;
    },
    setFilterFaculty(state, change) {
      state.filterFaculty = change;
    },
    setFilterDepartment(state, change) {
      state.filterDepartment = change;
    },
    setFilterPlace(state, change) {
      state.filterPlace = change;
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
              localStorage.removeItem("id");
              context.commit("destroyToken");
              context.commit("destroyUser");
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
      if (context.getters.loggedInId) {
        var tokenExp = new Date(jwt_decode(context.getters.token).exp * 1000);
        var currentTime = new Date();
        if (tokenExp < currentTime) {
          localStorage.removeItem("access_token");
          localStorage.removeItem("id");
          context.commit("destroyToken");
          context.commit("destroyUser");
          return new Promise.reject(new Error("Token is expired"));
        } else {
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
  }
});
