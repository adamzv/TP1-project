<template>
  <div class="home">
    <!-- TODO place for EventListComponent -->
    <EventListComponent />
  </div>
</template>

<script>

import EventListComponent from "../components/event/EventListComponent";
export default {
  name: "home",
  components: {EventListComponent}
};
</script>

<style lang="scss" scoped>
.home {
  text-align: center;
}
</style>
