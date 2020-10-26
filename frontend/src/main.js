import "@mdi/font/css/materialdesignicons.css";
import Buefy from "buefy";
import "buefy/dist/buefy.css";
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

new Vue({
  router,
  store,
  i18n,
  render: h => h(App)
}).$mount("#app");
