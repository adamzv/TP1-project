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
    <HeaderComponent class="element" />

    <router-view />
    <FooterComponent />
  </div>
</template>

<script>
import HeaderComponent from "@/components/HeaderComponent.vue";
import FooterComponent from "@/components/FooterComponent.vue";

export default {
  components: {
    HeaderComponent,
    FooterComponent
  },
  data() {
    return {
      loading: true,
      carouselHeight: Number
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

      // Print the carouselHeight (this variable is accessible from any component
      console.log(this.$store.state.carouselHeight);
    }
  },
  computed: {
    isLoading() {
      return this.$store.getters.loading.length > 0;
    }
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
</style>
