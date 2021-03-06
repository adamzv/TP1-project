<template>
  <section>
    <div style="margin-top: 24px;" class="container">
      <div class="page-margin">
        <h1 class="is-uppercase is-size-4" v-if="isModerator || isUser">
          Používateľská sekcia
        </h1>
        <h1 class="is-uppercase is-size-4" v-if="isAdmin">
          {{ $t("admin.section") }}
        </h1>
        <hr class="hr" />
        <div class="box">
          <template v-if="user">
            <b-modal v-model="newPlaceModal" has-modal-card trap-focus>
              <div class="modal-card" style="width: auto">
                <header class="modal-card-head">
                  <p class="modal-card-title">Zmena údajov</p>
                  <button
                    type="button"
                    class="delete"
                    @click="newPlaceModal = false"
                  />
                </header>
                <section class="modal-card-body">
                  <b-field v-bind:label="$t('name')">
                    <b-input v-model="name" required></b-input>
                  </b-field>
                  <b-field v-bind:label="$t('surname')">
                    <b-input v-model="surname" required></b-input>
                  </b-field>
                </section>
                <footer class="modal-card-foot">
                  <button
                    class="button"
                    type="button"
                    @click="newPlaceModal = false"
                  >
                    Zrušiť
                  </button>
                  <button class="button is-primary" @click="editUser">
                    Potvrdiť
                  </button>
                </footer>
              </div>
            </b-modal>
          </template>
          <div v-if="user">
            <h2 class="is-size-4">
              {{ loggedInName }}
              <a @click="newPlaceModal = true">
                <b-icon type="is-small" icon="account-cog"></b-icon>
              </a>
            </h2>

            <p>
              <span class="has-text-weight-semibold">
                {{ $t("admin.email_adress") }}:
              </span>
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
            <p>
              <a class="has-text-weight-semibold" @click="changePassword">
                {{ $t("admin.change_password") }}
              </a>
              <br />
              <a
                v-if="isUser && user.notify === null"
                class="has-text-weight-semibold"
                @click="notify"
              >
                Zmena práv
              </a>
            </p>
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
                v-bind:event-title-img="event.titleImg"
              />
            </template>
          </b-carousel-list>
        </template>
        <!-- Sprava udalosti -->
        <template v-if="isAdmin">
          <div id="app" class="container">
            <section>
              <b-tabs size="is-medium" class="block" :multiline="true">
                <b-tab-item
                  v-bind:label="$t('admin.statistics')"
                  icon="chart-pie"
                >
                  <template
                    v-if="
                      faculties && hodnota && online && faculties1 && hodnota1
                    "
                  >
                    <StatisticsComponent
                      :faculties="faculties"
                      :hodnota="hodnota"
                      :online="online"
                      :faculties1="faculties1"
                      :hodnota1="hodnota1"
                    />
                  </template>
                </b-tab-item>
                <b-tab-item
                  v-bind:label="$t('admin.event_management')"
                  icon="calendar-check"
                  @click="getEvents"
                >
                  <template v-if="events">
                    <EventManager :events="events" />
                  </template>
                </b-tab-item>
                <b-tab-item
                  v-bind:label="$t('admin.users')"
                  icon="account-box"
                  @click="getUsers"
                >
                  <template v-if="users">
                    <UserComponent :users="users" />
                  </template>
                </b-tab-item>
                <b-tab-item
                  v-bind:label="$t('filter.categories')"
                  icon="animation"
                >
                  <template v-if="category">
                    <CategoryComponent :category="category" />
                  </template>
                </b-tab-item>
              </b-tabs>
            </section>
          </div>
        </template>
        <!-- Sprava udalosti -->
        <template v-if="isModerator">
          <div id="app" class="container">
            <section>
              <b-tabs size="is-large" class="block">
                <b-tab-item
                  label="Správa udalostí"
                  icon="calendar-check"
                  @click="getEvents"
                >
                  <template v-if="events">
                    <EventManager :events="events" />
                  </template>
                </b-tab-item>
              </b-tabs>
            </section>
          </div>
        </template>
      </div>
    </div>
  </section>
</template>

<script>
import { ADMIN_ROLE, MODERATOR_ROLE, USER_ROLE } from "../const.js";
import EventManager from "../components/event/EventManager.vue";
import CategoryComponent from "../components/CategoryComponent.vue";
import UserComponent from "../components/UserComponent.vue";
import StatisticsComponent from "../components/StatisticsComponent.vue";
import EventCardComponent from "../components/event/EventCardComponent.vue";
import httpClient from "../httpClient.js";

export default {
  name: "profile",
  components: {
    EventManager,
    EventCardComponent,
    UserComponent,
    CategoryComponent,
    StatisticsComponent
  },
  data() {
    return {
      test: 0,
      events: [],
      users: [],
      category: [],
      online: [],
      faculties: [],
      hodnota: [],
      faculties1: [],
      hodnota1: [],
      newPlaceModal: false,
      name: "",
      surname: ""
    };
  },
  created() {
    // this function call is for when the user returns to the profile view
    // without this events list would be empty after router.back()
    this.getEvents();
    this.getUsers();
    this.getCategory();
    this.getFaculty();
    this.getOnlineUsers();
  },
  mounted() {
    this.loadProp(this.user);
  },
  methods: {
    changePassword() {
      httpClient
        .post("/users/password/create", { email: this.user.email })
        .then(() =>
          this.$buefy.toast.open({
            message: "Odkaz na zmenu hesla Vám príde na email.",
            type: "is-success"
          })
        )
        .catch(() =>
          this.$buefy.toast.open({
            message: "Niekde nastala chyba.",
            type: "is-danger"
          })
        );
    },
    notify() {
      httpClient
        .post(`/users/notify/${this.loggedInId}`, { notify: 1 })
        .then(() => {
          this.$buefy.toast.open({
            message: "Notifikácia bolo odoslaná!",
            type: "is-success"
          });
        })
        .catch(error => {
          console.log(error);
          this.$buefy.toast.open({
            message: "Notifikáciu sa nepodarilo odoslať!",
            type: "is-danger"
          });
        });
    },
    getEvents() {
      if (this.isAdmin) {
        this.loadEvents("/admin");
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
      this.$store.commit("pushToLoading", "Profile");
      httpClient
        .get(route)
        .then(response => {
          this.events = response.data;
          this.$store.commit("finishLoading", "Profile");
        })
        .catch(error => {
          console.log(error);
          this.$store.commit("finishLoading", "Profile");
        });
    },

    getUsers() {
      if (this.isAdmin) {
        this.$store.commit("pushToLoading", "Profile2");
        httpClient
          .get("/users")
          .then(response => {
            this.users = response.data;

            this.$store.commit("finishLoading", "Profile2");
          })
          .catch(error => {
            console.log(error);
            this.$store.commit("finishLoading", "Profile2");
          });
      }
    },
    getOnlineUsers() {
      if (this.isAdmin) {
        this.$store.commit("pushToLoading", "Profile2");
        httpClient
          .get("/stats/onlineUsers")
          .then(response => {
            this.online = response.data;

            this.$store.commit("finishLoading", "Profile2");
          })
          .catch(error => {
            console.log(error);
            this.$store.commit("finishLoading", "Profile2");
          });
      }
    },

    getCategory() {
      if (this.isAdmin) {
        this.$store.commit("pushToLoading", "Profile2");
        httpClient
          .get("/categories")
          .then(response => {
            this.category = response.data;

            this.$store.commit("finishLoading", "Profile2");
          })
          .catch(error => {
            console.log(error);
            this.$store.commit("finishLoading", "Profile2");
          });
      }
    },

    editUser() {
      httpClient
        .post("/users/changeUserName", {
          name: this.name,
          surname: this.surname
        })
        .then(() => {
          this.$router.go();
          this.newPlaceModal = false;
          this.$buefy.toast.open({
            message: "Meno a priezvisko bolo zmenené!",
            type: "is-success"
          });
        })
        .catch(error => {
          console.log(error);
          this.$store.commit("finishLoading", "Profile2");
          this.newPlaceModal = false;
          this.$buefy.toast.open({
            message: "Meno a priezvisko sa nepodarilo zmeniť!",
            type: "is-danger"
          });
        });
    },

    getFaculty() {
      if (this.isAdmin) {
        this.$store.commit("pushToLoading", "Profile2");
        httpClient
          .get("/stats/faculties")
          .then(response => {
            this.faculties = response.data.faculty;
            this.hodnota = response.data.pocet;
            this.faculties1 = response.data.faculty1;
            this.hodnota1 = response.data.pocet1;

            this.$store.commit("finishLoading", "Profile2");
          })
          .catch(error => {
            console.log(error);
            this.$store.commit("finishLoading", "Profile2");
          });
      }
    },
    loadProp(user) {
      if (user != null) {
        this.name = this.user.name;
        this.surname = this.user.surname;
      }
    }
  },

  // watching for a change in userRole is required because we have to wait
  // till user information is loaded in vuex store
  watch: {
    userRole(newVal) {
      if (newVal) {
        this.getFaculty();
        this.getEvents();
        this.getUsers();
        this.getCategory();
        this.getOnlineUsers();
        this.loadProp(this.user);
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
