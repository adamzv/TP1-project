<template>
  <div id="app">
    <div v-if="this.$store.getters.loading[0] == 'FilterComponent'">
      <b-loading
              class="loading-z-pos"
              :is-full-page="true"
              v-model="isLoading"
              :can-cancel="false"
      >
        <div class="lds-ring"><div></div><div></div><div></div><div></div></div>

      </b-loading>
    </div>

    <div v-else>
      <b-loading
              class="loading-z-pos"
              :is-full-page="true"
              v-model="isLoading"
              :can-cancel="false"
      >
        <div class="backLoading">
          <img
                  width="200"
                  height="200"
                  src="./assets/logo-UKF-transparent.png"
                  alt=""
                  class="rotate"
          />
        </div>

      </b-loading>
    </div>


    <template v-if="events.length > 0">
      <HeaderComponent :events="events.slice(0, 6)" class="element" />
    </template>

    <router-view :loaded-events="events" />
    <FooterComponent />

    <back-to-top bottom="50px" right="50px">
      <button type="button" class="btn-to-top">
        <b-icon icon="chevron-up" />
      </button>
    </back-to-top>
  </div>
</template>

<script>
import HeaderComponent from "@/components/HeaderComponent.vue";
import FooterComponent from "@/components/FooterComponent.vue";
import httpClient from "./httpClient";
import BackToTop from "vue-backtotop";

export default {
  components: {
    HeaderComponent,
    FooterComponent,
    BackToTop
  },
  data() {
    return {
      events: [],
      loading: true,
      carouselHeight: Number,
      filteredEvents: Object
    };
  },
  created() {
    window.addEventListener("resize", this.listenToCarouselHeight);
    this.$store.commit("retrieveUserIdFromStorage");
    if (this.$store.getters.loggedInId) {
      this.$store.commit("pushToLoading", "App");
      this.$store
        .dispatch("retrieveUserData")
        .then(() => {
          this.$store.commit("finishLoading", "App");
        })
        .catch(error => {
          console.log(error);
          if (error === "Token is expired") {
            this.$router.push("/login");
          }
          this.$store.commit("finishLoading", "App");
        });
    }
  },
  destroyed() {
    window.removeEventListener("resize", this.listenToCarouselHeight);
  },
  methods: {
    // Setting the carouselHeight in VUEX states
    listenToCarouselHeight() {
      const element = document.querySelector(".element");
      var style = getComputedStyle(element);
      this.carouselHeight = style.height;
      this.$store.commit("changeCarouselHeight", style.height);
    },
    toastGenerator(message) {
      if (message === "Event Full") {
        this.$buefy.toast.open({
          message: "Všetky miesta sú už obsadené!",
          type: "is-danger"
        });
      } else if (message === "User is already registered on event") {
        this.$buefy.toast.open({
          message: `Už ste zaregistrovaná/ý na udalosť!`,
          type: "is-danger"
        });
      } else if (message === "Email was successfully registered on event") {
        this.$buefy.toast.open({
          message: `Boli ste prihlásená/ý na udalosť.`,
          type: "is-danger"
        });
      }
    }
  },
  computed: {
    isLoading() {
      return this.$store.getters.loading.length > 0;
    }
  },
  watch: {
    isLoading(val) {
      if (!val) {
        if (this.$router.history.current.query.message) {
          this.toastGenerator(this.$router.history.current.query.message);
        }
      }
    }
  },
  mounted() {
    // App hned po starte
    this.$store.commit("pushToLoading", "AppEvents");
    httpClient.get(`/events`).then(response => {
      this.$store.commit("setCurrentlyInFilter", response.data);
      this.events = response.data.data;
      this.$store.commit("finishLoading", "AppEvents");
    });
  }
};
</script>

<style scoped lang="scss">

  .backLoading {
    width: 100%;
    height: 100%;
    background: white;
  }

  .lds-ring {
    display: inline-block;
    position: absolute;
    width: 60px;
    height: 60px;
    bottom: 0px;
    right: 25%;
    left: 50%;
    margin-left: -30px;
  }
  .lds-ring div {
    box-sizing: border-box;
    display: block;
    position: absolute;
    width: 40px;
    height: 40px;
    margin: 8px;
    border: 5px solid #4d4d4d;
    border-radius: 50%;
    animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
    border-color: #4d4d4d transparent transparent transparent;
  }
  .lds-ring div:nth-child(1) {
    animation-delay: -0.45s;
  }
  .lds-ring div:nth-child(2) {
    animation-delay: -0.3s;
  }
  .lds-ring div:nth-child(3) {
    animation-delay: -0.15s;
  }
  @keyframes lds-ring {
    0% {
      transform: rotate(0deg);
    }
    100% {
      transform: rotate(360deg);
    }
  }


  .rotate {
  background: linear-gradient(rgb(40, 184, 206), rgb(40, 184, 206)) left
      no-repeat,
    rgba(0, 0, 0, 0.3);
  background-size: 0% 100%;
  -webkit-text-fill-color: transparent;
  color: transparent;
  animation: loading 3s forwards infinite linear;
    position: absolute;
    top: 50%;
    left: 50%;

    margin: -100px 0 0 -100px;
}

@keyframes loading {
  100% {
    background-size: 100% 100%;
  }
}

.loading-overlay {
  background: rgb(2,0,36);
  background: linear-gradient(180deg, rgba(2,0,36,0) 45%, rgba(255,255,255,1) 86%, rgba(255,255,255,1) 100%);
}
.loading-z-pos {
  z-index: 2000;
}

.btn-to-top {
  width: 60px;
  height: 60px;
  padding: 10px 16px;
  font-size: 22px;
  line-height: 22px;
  opacity: 0.7;
}

.btn-to-top:hover {
  opacity: 1;
}
</style>
