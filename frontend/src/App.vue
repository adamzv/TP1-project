<template>
  <div id="app">
    <b-loading
      :is-full-page="true"
      v-model="loading"
      :can-cancel="false"
    ></b-loading>
    <HeaderComponent />
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
      loading: false
    };
  },
  mounted() {
    this.loading = true;
    this.$store.commit("retrieveUserIdFromStorage");
    if (this.$store.getters.loggedInId) {
      console.log(this.$store.getters.loggedInId);
      this.$store
        .dispatch("retrieveUserData")
        .then(response => {
          console.log(response);
          this.loading = false;
        })
        .catch(error => {
          console.log("fatal errorz");
          console.log(error);
          this.loading = false;
        });
    } else {
      this.loading = false;
    }
  }
};
</script>

<style scoped lang="scss"></style>
