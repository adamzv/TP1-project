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

    <back-to-top bottom="50px" right="50px">
      <button type="button" class="btn-to-top"><b-icon icon="chevron-up" /></button>
    </back-to-top>
  </div>
</template>

<script>
import HeaderComponent from "@/components/HeaderComponent.vue";
import FooterComponent from "@/components/FooterComponent.vue";
import httpClient from "./httpClient";
import BackToTop from 'vue-backtotop';

export default {
  components: {
    HeaderComponent,
    FooterComponent,
    BackToTop
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

<style scoped lang="scss">
  .btn-to-top {
    width: 60px;
    height: 60px;
    padding: 10px 16px;
    font-size: 22px;
    line-height: 22px;
    opacity: 0.7;
  }

  .btn-to-top:hover {
    opacity: 1.0;
  }
</style>
