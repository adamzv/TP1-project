<template>
  <div class="home">
    <!-- TODO place for EventListComponent -->
    <FilterComponent />
    <EventListComponent />
  </div>
</template>

<script>
import EventListComponent from "../components/event/EventListComponent";
import FilterComponent from "@/components/FilterComponent.vue";

export default {
  name: "home",
  components: { EventListComponent, FilterComponent }
};
</script>

<style lang="scss" scoped>
.home {
  text-align: center;
}
</style>
