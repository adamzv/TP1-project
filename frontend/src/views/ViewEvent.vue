/* * * Created by: Martin Gajdos * Date: 15. 11. 2020 * * Description: View
event details on a single page * */

<template>
  <div class="page-margin">
    <EventDetailsComponent
      v-bind:event-id="events.event.id"
      v-bind:event-name="events.event.name"
      v-bind:event-desc="events.event.desc"
      v-bind:event-room="events.event.room"
      v-bind:event-beginning="events.event.beginning"
      v-bind:event-end="events.event.end"
      v-bind:event-attendance-limit="events.event.attendance_limit"
      v-bind:event-lecturer="events.event.lecturer"
      v-bind:event-id-user="events.event.id_user"
      v-bind:event-id-place="events.event.id_place"
      v-bind:event-id-faculty="events.event.id_faculty"
      v-bind:event-id-department="events.event.id_department"
      v-bind:event-participants="events.event.participants"
      v-bind:event-user="events.event.user"
      v-bind:event-place="events.event.place"
      v-bind:event-department="events.event.department"
      v-bind:event-faculty="events.event.faculty"
      v-bind:event-categories="events.event.categories"
      v-bind:event-pdf="events.event.pdf"
      v-bind:event-images="events.event.images"
    />
  </div>
</template>

<script>
import EventDetailsComponent from "../components/event/EventDetailsComponent";
import httpClient from "../httpClient";

export default {
  name: "ViewEvent",
  components: { EventDetailsComponent },

  data() {
    return {
      event_id: Number,
      events: []
    };
  },

  created() {
    this.event_id = this.$route.params.eventId;

    httpClient.get(`/events/${this.event_id}`).then(response => {
      this.events = response.data;
    });
  }
};
</script>

<style scoped>
.page-margin {
  padding-top: 30px;
  padding-bottom: 30px;
}
</style>
