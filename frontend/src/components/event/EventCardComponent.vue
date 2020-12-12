/* * * Created by: Martin Gajdos * Date: 26. 10. 2020 * * Description: This
component takes in all the event data coming from EventListComponent and renders
* them in a card-like style. * */

<template>
  <router-link
    :to="{ name: 'showEvent', params: { eventId: this.eventId } }"
    class="column is-narrow card-container"
  >
    <!-- Actual event card -->
    <div class="panel _card">
      <!-- Card heading -->
      <div
        class="panel-heading"
        v-bind:class="{
          eventBackColorFPV: eventIdFaculty == 1,
          eventBackColorFF: eventIdFaculty == 4,
          eventBackColorFSS: eventIdFaculty == 3,
          eventBackColorFP: eventIdFaculty == 5,
          eventBackColorFSVZ: eventIdFaculty == 2,
          eventBackColorUKF: eventIdFaculty == 6,
          eventBackColorLIB: eventIdFaculty == 7
        }"
      >
        <!-- Event name -->
        <p class="alignLeft" v-if="eventName">
          <span v-if="eventName.length <= 11">
            {{ eventName }}
          </span>

          <span v-else>
            {{ shortenName }}
          </span>
        </p>

        <!-- Faculty name -->
        <p
          class="alignRight"
          style="font-style: italic; font-size: 15px; padding-top: 5px;"
        >
          {{ eventFaculty.name }}
        </p>

        <div style="clear: both;"></div>
      </div>

      <!-- Test image -->
      <div
        class="panel-block"
        style="padding: 0; max-height: 230px; overflow-y: hidden;"
      >
        <img
          v-if="titleImage"
          style="width: 100%;"
          :src="getImgUrl(titleImage)"
          alt="alternatetext"
        />
        <img
          v-else
          style="width: 100%;"
          src="https://www.nitralive.sk/images/stories/vystavba/ukf/laboratoria/laboratoria-ukf-nitra-vizualizacia-titulka.jpg"
          alt="alternatetext"
        />
      </div>

      <!-- Quick details about the event -->
      <div
        class="quickDetailsHeader"
        v-bind:class="{
          eventBackColorFPV: eventIdFaculty == 1,
          eventBackColorFF: eventIdFaculty == 4,
          eventBackColorFSS: eventIdFaculty == 3,
          eventBackColorFP: eventIdFaculty == 5,
          eventBackColorFSVZ: eventIdFaculty == 2,
          eventBackColorUKF: eventIdFaculty == 6,
          eventBackColorLIB: eventIdFaculty == 7
        }"
      >
        <!-- Event date -->
        <h1 class="alignLeft">
          <strong style="color: white;">
            {{ eventDateSplit }}
          </strong>
        </h1>

        <!-- Event time -->
        <h1 class="alignRight" style="font-style: italic; color: white;">
          {{ eventTimeSplit }}
        </h1>

        <br />

        <!-- School department -->
        <h1 class="alignLeft">
          <strong v-if="eventDepartment" style="color: white;">
            {{ eventDepartment.name }}
          </strong>

          <strong v-else style="color: white;">
            Vsetky katedry
          </strong>
        </h1>

        <!-- Place of the event -->
        <h1 class="alignRight" style="color: white; font-style: italic;">
          {{ eventPlace.name }}
        </h1>

        <div style="clear: both;"></div>
      </div>

      <!-- Details of the event -->
      <div
        style="overflow-y: scroll;"
        class="eventDetails"
        v-if="eventDesc"
        v-bind:class="{
          eventBorderColorFPV: eventIdFaculty == 1,
          eventBorderColorFF: eventIdFaculty == 4,
          eventBorderColorFSS: eventIdFaculty == 3,
          eventBorderColorFP: eventIdFaculty == 5,
          eventBorderColorFSVZ: eventIdFaculty == 2,
          eventBorderColorUKF: eventIdFaculty == 6,
          eventBorderColorLIB: eventIdFaculty == 7
        }"
      >
        <p>
          {{ eventDesc }}
        </p>
      </div>

      <div
        style="overflow-y: scroll;"
        class="eventDetails"
        v-else
        v-bind:class="{
          eventBorderColorFPV: eventIdFaculty == 1,
          eventBorderColorFF: eventIdFaculty == 4,
          eventBorderColorFSS: eventIdFaculty == 3,
          eventBorderColorFP: eventIdFaculty == 5,
          eventBorderColorFSVZ: eventIdFaculty == 2,
          eventBorderColorUKF: eventIdFaculty == 6,
          eventBorderColorLIB: eventIdFaculty == 7
        }"
      >
        <p style="color: #adadad;">
          Bez popisu.
        </p>
      </div>

      <!-- Separator line -->
      <hr style="margin: 0px;" />

      <!-- Event tags -->
      <div class="eventTags">
        <b-taglist>
          <b-tag
            v-for="tag in eventCategories"
            :key="tag.id"
            size="is-medium"
            class="has-text-white"
            v-bind:class="{
              eventBackColorFPV: eventIdFaculty == 1,
              eventBackColorFF: eventIdFaculty == 4,
              eventBackColorFSS: eventIdFaculty == 3,
              eventBackColorFP: eventIdFaculty == 5,
              eventBackColorFSVZ: eventIdFaculty == 2,
              eventBackColorUKF: eventIdFaculty == 6,
              eventBackColorLIB: eventIdFaculty == 7
            }"
          >
            #{{ tag.name }}
          </b-tag>
        </b-taglist>
      </div>
    </div>
  </router-link>
</template>

<script>
import httpClient from "../../httpClient.js";

export default {
  name: "EventCardComponent",

  data() {
    return {
      clicked: false,
      titleImage: null
    };
  },

  computed: {
    eventDateSplit: function() {
      return this.eventBeginning.substr(0, this.eventBeginning.indexOf(" "));
    },

    eventTimeSplit: function() {
      return this.eventBeginning.substr(this.eventBeginning.indexOf(" ") + 1);
    },

    shortenName: function() {
      return this.eventName.substr(0, 12) + "...";
    },

    shortenDepartment: function() {
      return this.eventDepartment.substr(0, 12) + "...";
    }
  },

  // Props that this component is expecting to be passed from EventListComponent
  props: {
    eventId: {
      type: Number,
      required: false
    },
    eventName: {
      type: String,
      required: false
    },
    eventDesc: {
      type: String,
      required: false
    },
    eventRoom: {
      type: String,
      required: false
    },
    eventBeginning: {
      type: String,
      required: false
    },
    eventEnd: {
      type: String,
      required: false
    },
    eventAttendanceLimit: {
      type: Number,
      required: false
    },
    eventLecturer: {
      type: String,
      required: false
    },
    eventIdUser: {
      type: Number,
      required: false
    },
    eventIdPlace: {
      type: Number,
      required: false
    },
    eventIdFaculty: {
      type: Number,
      required: false
    },
    eventIdDepartment: {
      type: Number,
      required: false
    },
    eventParticipants: {
      type: Number,
      required: false
    },
    eventUser: {
      type: Object,
      required: false
    },
    eventPlace: {
      type: Object,
      required: false
    },
    eventDepartment: {
      type: Object,
      required: false
    },
    eventFaculty: {
      type: Object,
      required: false
    },
    eventCategories: {
      type: Array,
      required: false
    },
    eventTitleImg: {
      type: Array,
      required: false
    }
  },

  methods: {
    redirectToView() {
      this.$router.push({
        name: "Event",
        params: { data: this.props }
      });
    },
    getImgUrl(value) {
      return process.env.VUE_APP_IMAGES_STORAGE_URL + value;
    }
  },
  created() {
    if (this.eventTitleImg && this.eventTitleImg[0]) {
      this.$store.commit("pushToLoading", "EventCardLoadImages");
      httpClient
        .get(`/files/titleImg/${this.eventId}`)
        .then(response => {
          this.titleImage = response.data.title_images_path.title_image1_path;
          this.$store.commit("finishLoading", "EventCardLoadImages");
        })
        .catch(() => {
          this.$store.commit("finishLoading", "EventCardLoadImages");
        });
    }
  }
};
</script>

<style lang="scss" scoped>
.card-container {
  max-width: 500px;
  color: #525252;
}

.alignLeft {
  float: left !important;
}

.alignRight {
  float: right !important;
}

.column {
  margin: 20px;

  .panel .panel-heading {
    color: white;
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
  }
}

._card {
  padding: 0px;
  margin: 10px;
  border-radius: 4px;
}

.quickDetailsHeader {
  padding: 7px 20px 7px 20px;
}

.eventDetails {
  padding: 12px;
  text-align: justify;
  height: 200px;
  max-height: 200px;
}

.eventDetailsNone {
  height: 0px;
}

.eventTags {
  padding: 10px;
}

.eventBackColorUKF {
  background: #55c8d9;
}

.eventBackColorLIB {
  background: #7f1810;
}

.eventBackColorFPV {
  background: #00a360;
}

.eventBackColorFF {
  background: #d40075;
}

.eventBackColorFSS {
  background: #f39200;
}

.eventBackColorFP {
  background: #0062a7;
}

.eventBackColorFSVZ {
  background: #b2b2b2;
}

.eventBorderColorUKF {
  border-left: 4px solid #c9f8ff;
}

.eventBorderColorLIB {
  border-left: 4px solid #b5a6a5;
}

.eventBorderColorFPV {
  border-left: 4px solid #b4dbcb;
}

.eventBorderColorFF {
  border-left: 4px solid #e3b3ce;
}

.eventBorderColorFSS {
  border-left: 4px solid #e3cba8;
}

.eventBorderColorFP {
  border-left: 4px solid #9ec1d9;
}

.eventBorderColorFSVZ {
  border-left: 4px solid #d8d8d8;
}

.panel {

  /*box-shadow: 0px 5px 10px #0057ab;*/
  -webkit-box-shadow: 0px 18px 42px -17px rgba(0, 0, 0, 0.74);
  -moz-box-shadow: 0px 18px 42px -17px rgba(0, 0, 0, 0.74);
  box-shadow: 0px 18px 42px -17px rgba(0, 0, 0, 0.74);
  -webkit-transition: all 0.25s;
  transition: all 0.25s;
  cursor: pointer;
}

.panel:hover {

  -webkit-box-shadow: 0px 24px 46px -22px rgba(0, 0, 0, 0.74);
  -moz-box-shadow: 0px 24px 46px -22px rgba(0, 0, 0, 0.74);
  box-shadow: 0px 24px 46px -22px rgba(0, 0, 0, 0.74);

  /*box-shadow: 0px 15px 25px -5px #0057ab;*/
  -webkit-transform: scale(1.015);
  transform: scale(1.015);

}

.panel:active {
  /*box-shadow: 0px 4px 8px #0065c8;*/
  -webkit-transform: scale(0.98);
  transform: scale(0.98);
}

/* Scrollbar style */
/* Width */
::-webkit-scrollbar {
  width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
  margin: 5px;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 10px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555;
}

/* Media queries */
@media only screen and (max-width: 1072px) {
  .card-container {
    max-width: fit-content;
    width: auto;
  }
}
</style>
