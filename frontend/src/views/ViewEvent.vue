/* * * Created by: Martin Gajdos * Date: 15. 11. 2020 * * Description: View
event details on a single page * */

<template>
  <div class="page-margin">
    <template v-if="event">
      <EventDetailsComponent
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
        v-bind:event-pdf="event.pdf"
        v-bind:event-images="event.images"
      />
    </template>
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
      event: null
    };
  },

  created() {
    this.event_id = this.$route.params.eventId;
    this.$store.commit("pushToLoading", "ViewEvent");
    httpClient.get(`/events/${this.event_id}`).then(response => {
      this.event = response.data.event;
      this.$store.commit("finishLoading", "ViewEvent");
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
