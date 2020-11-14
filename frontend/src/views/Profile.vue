<template>
  <section>
    <div style="margin-top: 24px;" class="container">
      <!-- Nova udalost -->
      <h1 class="is-uppercase is-size-4">
        Používateľská sekcia
      </h1>
      <hr class="hr" />
      <div class="box">
        <div v-if="user">
          <h1>{{ loggedInName }}</h1>
          <p>{{ user.email }}</p>
        </div>
        <div v-if="isAdmin">ADMIN</div>
        <template v-if="events">
          <EventManager :events="events" />
        </template>

        <div v-if="isModerator">MODERATOR</div>
      </div>
    </div>
  </section>
</template>

<script>
import { ADMIN_ROLE, MODERATOR_ROLE } from "../const.js";
import EventManager from "../components/event/EventManager.vue";
import httpClient from "../httpClient.js";

export default {
  name: "profile",
  components: {
    EventManager
  },
  data() {
    return {
      events: []
      // user: null
    };
  },
  created() {
    this.getEvents();
  },
  methods: {
    getEvents() {
      console.log(`user role: ${this.userRole}`);
      if (this.isAdmin) {
        httpClient
          .get("/events")
          .then(response => {
            console.log(response);
            this.events = response.data.data;
          })
          .catch(error => {
            console.log(error);
          });
      } else if (this.isModerator) {
        httpClient
          .get(`/events?filter=id_user=${this.loggedInId}`)
          .then(response => {
            console.log("moderator");
            console.log(response);
            this.events = response.data.data;
          })
          .catch(error => {
            console.log(error);
          });
      }
    }
  },
  // watching for a change in userRole is required because we have to wait
  // till user information is loaded in vuex store
  watch: {
    userRole(newVal) {
      console.log(newVal);
      if (newVal) {
        this.getEvents();
      }
    }
  },
  computed: {
    loggedInId() {
      return this.$store.getters.loggedInId;
    },
    loggedInName() {
      return this.$store.getters.loggedInName;
    },
    userRole() {
      return this.user ? this.$store.getters.loggedInUser.id_role : null;
    },
    // user is used as a computed property
    user() {
      return this.$store.getters.loggedInUser || null;
    },
    isAdmin() {
      return this.userRole === ADMIN_ROLE;
    },
    isModerator() {
      return this.userRole === MODERATOR_ROLE;
    }
  }
};
</script>

<style></style>
