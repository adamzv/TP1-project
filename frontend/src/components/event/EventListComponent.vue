/* * * Created by: Martin Gajdos * Date: 26. 10. 2020 * * Description: This
component contains data about every event & renders event cards * and event
details accordingly. * */

<template>
  <!-- Temporary top padding -->
  <div style="padding-top: 30px;">
    <!-- Using Bulma column layout system -->
    <div class="columns is-mobile is-multiline is-centered">
      <!-- Actual column iterated through the event list -->

      <!-- EventCardComponent reference, passing all the required props -->
      <EventCardComponent
        v-bind:event-id="event.id"
        v-bind:event-name="event.name"
        v-bind:event-desc="event.desc"
        v-bind:event-date="event.date"
        v-bind:event-department="event.department"
        v-bind:event-place="event.place"
        v-bind:event-time="event.time"
        v-bind:event-faculty="event.faculty"
        v-bind:event-tags="event.tags"
        v-for="event in events"
        :key="event.id"
      />
    </div>
    <EventDetailsComponent />
  </div>
</template>

<script>
import EventCardComponent from "./EventCardComponent";
import EventDetailsComponent from "./EventDetailsComponent";

export default {
  name: "EventListComponent",

  components: {
    EventCardComponent,
    EventDetailsComponent
  },

  // Test data (later the data will be fetched from the backend as .json objects)
  data() {
    return {
      events: [
        {
          id: 0,
          name: "Karierny den",
          desc:
            "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod " +
            " consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse",
          date: "21. - 23.12.2020",
          department: "Katedra informatiky",
          place: "FPV Aula",
          time: "12:30",
          faculty: "FPV",
          tags: [
            { id: 0, value: "testtag" },
            { id: 1, value: "ki" },
            { id: 2, value: "ukf" },
            { id: 3, value: "dalsitag" }
          ]
        },
        {
          id: 1,
          name: "Taky den",
          desc:
            "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod " +
            "tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam," +
            " quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo" +
            " consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse",
          date: "21. - 23.12.2020",
          department: "Katedra logisktiy",
          place: "FF Aula",
          time: "14:30",
          faculty: "FF",
          tags: [
            { id: 0, value: "filozofia" },
            { id: 1, value: "katedra" },
            { id: 2, value: "ukf" }
          ]
        },
        {
          id: 2,
          name: "Hentaky den",
          desc:
            "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod " +
            "tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam," +
            " quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo",
          date: "21. - 23.12.2020",
          department: "Katedra blabla",
          place: "FSS Aula",
          time: "10:32",
          faculty: "FSS",
          tags: [
            { id: 0, value: "fss" },
            { id: 1, value: "univerzita" },
            { id: 2, value: "customtag" }
          ]
        },
        {
          id: 3,
          name: "Hentaky den",
          desc:
            "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod " +
            "tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam," +
            " quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo",
          date: "21. - 23.12.2020",
          department: "Katedra blabla",
          place: "FSS Aula",
          time: "10:32",
          faculty: "FSS",
          tags: [
            { id: 0, value: "fss" },
            { id: 1, value: "univerzita" },
            { id: 2, value: "customtag" }
          ]
        },
        {
          id: 3,
          name: "Hentaky den",
          desc:
            "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod " +
            "tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam," +
            " quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo",
          date: "21. - 23.12.2020",
          department: "Katedra blabla",
          place: "FSS Aula",
          time: "10:32",
          faculty: "FSS",
          tags: [
            { id: 0, value: "fss" },
            { id: 1, value: "univerzita" },
            { id: 2, value: "customtag" }
          ]
        }
      ]
    };
  }
};
</script>

<style lang="scss" scoped>
.column {
  margin: 20px;

  .panel .panel-heading {
    color: white;
  }
}
</style>
