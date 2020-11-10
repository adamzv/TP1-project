import "@mdi/font/css/materialdesignicons.css";
import Buefy from "buefy";
import "buefy/dist/buefy.css";
// import "@creativebulma/bulma-divider";
import "./assets/styles.css";
import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import i18n from "./i18n";

// imports Moment.js plugin moment-countdown that integrates Moment with Countdown.js
const momentCountdown = require("moment-countdown");

Vue.config.productionTip = false;
Vue.use(Buefy);
Vue.use(momentCountdown);

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (!store.getters.loggedIn) {
      next({
        name: "login"
      });
    } else {
      if (store.getters.permissionToAddEvents) {
        next();
      } else {
        next({ name: "home" });
      }
    }
  } else if (to.matched.some(record => record.meta.requiresVisitor)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (store.getters.loggedIn) {
      next({
        name: "home"
      });
    } else {
      next();
    }
  } else {
    next(); // make sure to always call next()!
  }
});

new Vue({
  router,
  store,
  i18n,
  render: h => h(App)
}).$mount("#app");
