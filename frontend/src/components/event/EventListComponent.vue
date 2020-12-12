/* * * Created by: Martin Gajdos * Date: 26. 10. 2020 * * Description: This
component contains data about every event & renders event cards * and event
details accordingly. * */

<template>
  <!-- Temporary top padding -->
  <div style="padding-top: 30px;">

    <div v-if="this.$store.getters.getCurrentlyInFilter.data != 0">
      <!-- Using Bulma column layout system -->
      <div class="columns is-mobile is-multiline is-centered">
        <!-- Actual column iterated through the event list -->
        <!-- EventCardComponent reference, passing all the required props -->

        <!-- Go through the filter object containing filtered events and render cards -->
        <EventCardComponent
          v-bind:event-id="event.id"
          v-bind:event-name="event.name"
          v-bind:event-desc="event.desc"
          v-bind:event-room="event.room"
          v-bind:event-beginning="event.beginning"
          v-bind:event-end="event.end"
          v-bind:event-attendance-limit="event.attendance_limit"
          v-bind:event-lecturer="event.lecturer"
          v-bind:event-id-user="event.id_user"
          v-bind:event-id-place="event.id_place"
          v-bind:event-id-faculty="event.id_faculty"
          v-bind:event-id-department="event.id_department"
          v-bind:event-participants="event.participants"
          v-bind:event-user="event.user"
          v-bind:event-place="event.place"
          v-bind:event-department="event.department"
          v-bind:event-faculty="event.faculty"
          v-bind:event-categories="event.categories"
          v-bind:event-title-img="event.titleImg"
          v-for="event in this.$store.getters.getPages[pageId - 2]"
          v-bind:key="event.id"
        />
      </div>
    </div>

    <div v-else>
      <strong>Nenašli sa žiadne udalosti!</strong>
    </div>
  </div>
</template>

<script>
import EventCardComponent from "./EventCardComponent";

export default {
  name: "EventListComponent",

  components: {
    EventCardComponent
  },

  props: {
    pageId: Number,
    events: Array
  },

  data() {
    return {
      events: []
    };
  },

  mounted() {}

};
</script>

<style lang="scss" scoped>
.column {
  margin: 20px;

  .panel .panel-heading {
    color: white;
  }
}

ul {
  margin-top: 10px;
  padding: 0px;
}

li {
  list-style: none;
}
</style>
