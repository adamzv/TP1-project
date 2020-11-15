import Vue from "vue";
import Router from "vue-router";
import Home from "./views/Home.vue";
import ManageEvent from "./views/ManageEvent.vue";
import NotFound from "./views/NotFound.vue";
import Login from "./views/Login.vue";
import ViewEvent from "./views/ViewEvent";

Vue.use(Router);

export default new Router({
  mode: "history",
  base: process.env.BASE_URL,
  routes: [
    {
      path: "/",
      name: "home",
      component: Home
    },
    {
      path: "/pridat",
      name: "addEvent",
      component: ManageEvent,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: "/event/:eventId",
      name: "showEvent",
      component: ViewEvent,
    },
    {
      path: "/login",
      name: "login",
      component: Login,
      meta: {
        requiresVisitor: true
      }
    },
    {
      path: "*",
      component: NotFound
    }
  ]
});
