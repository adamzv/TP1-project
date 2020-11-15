/*
*
* Created by: Martin Gajdos
* Date: 15. 11. 2020
*
* Description: View event details on a single page
*
*/

<template>
    <div style="padding-top: 30px; padding-bottom: 30px;">
        <EventDetailsComponent
                v-bind:event-id="event.event.id"
                v-bind:event-name="event.event.name"
                v-bind:event-desc="event.event.desc"
                v-bind:event-room="event.event.room"
                v-bind:event-beginning="event.event.beginning"
                v-bind:event-end="event.event.end"
                v-bind:event-attendance-limit="event.event.attendance_limit"
                v-bind:event-lecturer="event.event.lecturer"
                v-bind:event-id-user="event.event.id_user"
                v-bind:event-id-place="event.event.id_place"
                v-bind:event-id-faculty="event.event.id_faculty"
                v-bind:event-id-department="event.event.id_department"
                v-bind:event-participants="event.event.participants"
                v-bind:event-user="event.event.user"
                v-bind:event-place="event.event.place"
                v-bind:event-department="event.event.department"
                v-bind:event-faculty="event.event.faculty"
                v-bind:event-categories="event.event.categories"
        />
    </div>
</template>

<script>

    import EventDetailsComponent from "../components/event/EventDetailsComponent";
    import httpClient from "../httpClient";

    export default {
        name: "ViewEvent",
        components: {EventDetailsComponent},

        data() {
            return {
                event_id: Number,
                event: []
            }
        },

        created() {
            this.event_id = this.$route.params.eventId;
            console.log(this.event_id);

            httpClient.get(`/events/${this.event_id}`)
                .then(response => {
                    this.event = response.data;
                });
        }
    }
</script>

<style scoped>

</style>