import Vue from "vue";
import Router from "vue-router";
import Home from "./views/Home.vue";
import NotFound from "./views/NotFound.vue";
import Login from "./views/Login.vue";
import ViewEvent from "./views/ViewEvent";
import Profile from "./views/Profile.vue";
import PasswordReset from "./views/PasswordReset.vue";

Vue.use(Router);

// TODO: implement scroll behaviour to router so that it can remember scroll positions

export default new Router({
  mode: "history",
  base: process.env.BASE_URL,
  routes: [
    {
      path: "/",
      name: "home",
      component: Home,
      props: true
    },
    {
      path: "/event/:eventId",
      name: "showEvent",
      component: ViewEvent
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
      path: "/profile",
      name: "profile",
      component: Profile,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: "/passwordReset/:token",
      component: PasswordReset,
      name: "passwordReset"
    },
    {
      path: "*",
      component: NotFound
    }
  ]
});
