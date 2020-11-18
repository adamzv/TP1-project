<template>
  <section>
    <div style="margin-top: 24px;" class="container">
      <div class="page-margin">
        <h1 class="is-uppercase is-size-4">
          Používateľská sekcia
        </h1>
        <hr class="hr" />
        <div class="box">
          <div v-if="user">
            <h2 class="is-size-4">{{ loggedInName }}</h2>
            <p>
              <span class="has-text-weight-semibold">Emailová adresa:</span>
              {{ user.email }}
              <b-tooltip
                label="Verifikovaný email"
                position="is-right"
                type="is-primary"
              >
                <b-icon
                  type="is-primary"
                  size="is-small"
                  icon="shield-check"
                  v-if="user.email_verified_at"
                ></b-icon>
              </b-tooltip>
            </p>
            <p><a class="has-text-weight-semibold" href="#">Zmeniť heslo</a></p>
          </div>
        </div>
        <!-- Pouzivatelska sekcia -->
        <template v-if="isUser">
          <h1 class="is-uppercase is-size-4">
            Navštívené udalosti
          </h1>
          <hr class="hr" />
          <b-carousel-list
            :animated="true"
            v-model="test"
            :data="events"
            :items-to-show="2"
          >
            <template slot="item" slot-scope="event">
              <EventCardComponent
                v-bind:event-id="event.id"
                v-bind:event-name="event.name"
                v-bind:event-desc="event.desc"
                v-bind:event-room="event.room"
                v-bind:event-beginning="event.beginning"
                v-bind:event-end="event.end"
                v-bind:event-attendance-limit="event.attendance_limit"
                v-bind:event-lecturer="event.lecturer"
                v-bind:event-id-user="event.id_user"
                v-bind:event-id-place="event.id_place"
                v-bind:event-id-faculty="event.id_faculty"
                v-bind:event-id-department="event.id_department"
                v-bind:event-participants="event.participants"
                v-bind:event-user="event.user"
                v-bind:event-place="event.place"
                v-bind:event-department="event.department"
                v-bind:event-faculty="event.faculty"
                v-bind:event-categories="event.categories"
              />
            </template>
          </b-carousel-list>
        </template>
        <!-- Sprava udalosti -->
        <template v-if="isModerator || isAdmin">
          <h1 class="is-uppercase is-size-4">
            Správa udalostí
          </h1>
          <hr class="hr" />
          <template v-if="events">
            <EventManager :events="events" />
          </template>
        </template>
      </div>
    </div>
  </section>
</template>

<script>
import { ADMIN_ROLE, MODERATOR_ROLE, USER_ROLE } from "../const.js";
import EventManager from "../components/event/EventManager.vue";
import EventCardComponent from "../components/event/EventCardComponent.vue";
import httpClient from "../httpClient.js";

export default {
  name: "profile",
  components: {
    EventManager,
    EventCardComponent
  },
  data() {
    return {
      test: 0,
      events: []
    };
  },
  created() {
    // this function call is for when the user returns to the profile view
    // without this events list would be empty after router.back()
    this.getEvents();
  },
  methods: {
    getEvents() {
      if (this.isAdmin) {
        this.loadEvents("/events");
      } else if (this.isModerator) {
        this.loadEvents(`/events?filter=id_user=${this.loggedInId}`);
      } else if (this.isUser) {
        this.loadEvents(`/events?filter=event_user_id=${this.loggedInId}`);
      }
    },
    /**
     * This is a generic function which loads available events into this.events property.
     */
    loadEvents(route) {
      httpClient
        .get(route)
        .then(response => {
          this.events = response.data.data;
        })
        .catch(error => {
          console.log(error);
        });
    }
  },
  // watching for a change in userRole is required because we have to wait
  // till user information is loaded in vuex store
  watch: {
    userRole(newVal) {
      if (newVal) {
        this.getEvents();
      }
    },
    newEventSubmitted(newVal) {
      if (newVal) {
        this.getEvents();
        this.$store.commit("submitNewEvent", false);
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
    },
    isUser() {
      return this.userRole === USER_ROLE;
    },
    newEventSubmitted() {
      return this.$store.getters.newEventSubmitted;
    }
  }
};
</script>

<style>
/* For some reason carousel uses box-shadow 
   when it goes past first 2 items, this css style reverts it  */
.carousel-list.has-shadow {
  -webkit-box-shadow: 0px 0px 0px;
  box-shadow: 0px 0px 0px;
}

  .page-margin {
    margin-left: 20px;
    margin-right: 20px;
  }
</style>
