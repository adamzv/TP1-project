<template>
  <div id="app">
    <HeaderComponent />
    <p>{{ msg }}</p>
    <FilterComponent />
    <router-view />
    <FooterComponent />
  </div>
</template>

<script>
import HeaderComponent from "@/components/HeaderComponent.vue";
import FooterComponent from "@/components/FooterComponent.vue";
import FilterComponent from "@/components/FilterComponent.vue";
import httpClient from "./httpClient";

export default {
  components: {
    HeaderComponent,
    FooterComponent,
    FilterComponent
  },
  data() {
    return {
      msg: "todo"
    };
  },
  methods: {
    call() {
      httpClient
        .get("/places")
        .then(response => {
          this.msg = response;
        })
        .catch(error => {
          this.msg = error;
        });
    }
  },
  created() {
    this.call();
  }
};
</script>

<style scoped lang="scss"></style>
