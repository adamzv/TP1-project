<template>
  <div id="app">
    <b-loading
      :is-full-page="true"
      v-model="loading"
      :can-cancel="false"
    ></b-loading>
    <HeaderComponent class="element"/>

    <router-view />
    <FooterComponent />
  </div>
</template>

<script>
import HeaderComponent from "@/components/HeaderComponent.vue";
import FooterComponent from "@/components/FooterComponent.vue";
import httpClient from "./httpClient";

export default {
  components: {
    HeaderComponent,
    FooterComponent
  },
  data() {
    return {
      loading: true,
      carouselHeight: Number,
      filteredEvents: Object
    };
  },
  created() {

    window.addEventListener('resize', this.listenToCarouselHeight);
    this.$store.commit("retrieveUserIdFromStorage");
    if (this.$store.getters.loggedInId) {
      this.$store
        .dispatch("retrieveUserData")
        .then(() => {
          this.loading = false;
        })
        .catch(() => {
          this.loading = false;
        });
    } else {
      this.loading = false;
    }
  },

  destroyed() { window.removeEventListener('resize', this.listenToCarouselHeight); },

  methods: {

      // Setting the carouselHeight in VUEX states
      listenToCarouselHeight () {
      const element = document.querySelector('.element');
      var style = getComputedStyle(element);
      this.carouselHeight = style.height;
      this.$store.commit("changeCarouselHeight", style.height);

      // Print the carouselHeight (this variable is accessible from any component
      console.log(this.$store.state.carouselHeight);
    }
  },

  mounted() {
    // App hned po starte
    httpClient.get(`/events`)
      .then(response => {
        this.$store.commit('setCurrentlyInFilter', response.data);
      });
  }
};
</script>

<style scoped lang="scss"></style>
