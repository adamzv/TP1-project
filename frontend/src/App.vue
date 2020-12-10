<template>
  <div id="app">
    <b-loading
      class="loading-z-pos"
      :is-full-page="true"
      v-model="isLoading"
      :can-cancel="false"
    >
      <img
        width="200"
        height="200"
        src="./assets/logo-UKF-transparent.png"
        alt=""
        class="rotate"
      />
    </b-loading>
    <template v-if="events.length > 0">
      <HeaderComponent :events="events" class="element" />
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
        .catch(() => {
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
        // TODO toast is shown multiple times
        if (this.$router.history.current.query.message) {
          this.$buefy.toast.open({
            message: `Boli ste prihlásená/ý na udalosť.`,
            duration: 3500,
            type: "is-success"
          });
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
.rotate {
  background: linear-gradient(rgb(40, 184, 206), rgb(40, 184, 206)) left
      no-repeat,
    rgba(0, 0, 0, 0.3);
  background-size: 0% 100%;
  -webkit-text-fill-color: transparent;
  color: transparent;
  animation: loading 3s forwards infinite linear;
}

@keyframes loading {
  100% {
    background-size: 100% 100%;
  }
}

.loading-overlay {
  background: rgba(255, 255, 255, 1);
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
