<template>
  <div id="app">
    <HeaderComponent />
    <FilterComponent />
    <router-view />
    <FooterComponent />
  </div>
</template>

<script>
import HeaderComponent from "@/components/HeaderComponent.vue";
import FooterComponent from "@/components/FooterComponent.vue";
import FilterComponent from "@/components/FilterComponent.vue";

export default {
  components: {
    HeaderComponent,
    FooterComponent,
    FilterComponent
  }
};
</script>

<style scoped lang="scss"></style>
