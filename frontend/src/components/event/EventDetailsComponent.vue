/* * * Created by: Martin Gajdos * Date: 26. 10. 2020 * * Description: This
component takes in data from EventListComponent and renders them in a * detailed
format. * */

<template>
  <div style="max-width: 1500px; margin: 0 auto;">
    <!-- Actual card -->
    <article class="_card message is-medium">
      <!-- Card header -->
      <div
        class="message-header"
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
        <p>{{ eventName }}</p>
        <button class="delete is-medium" @click="goBack()"></button>
      </div>

      <!-- Individual sections of the card -->
      <div class="columns">
        <!-- Section 1 -->
        <div class="column is-3-desktop section1 eventDetailsHeaderColor">
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

          <div style="padding-top: 20px;">
            <b-icon icon="clock-time-four-outline"></b-icon>
            <strong style="padding-left: 5px;">KEDY</strong>
          </div>

          <p style="font-size: medium; padding-top: 10px;">
            {{ getDay() }}. {{ getMonth() }} {{ getYear() }}
          </p>

          <div style="padding-top: 20px;">
            <b-icon icon="map-marker"></b-icon>
            <strong style="padding-left: 5px;">KDE</strong>
          </div>

          <p style="font-size: medium; padding-top: 10px;">
            Miestnost {{ eventRoom }}
            <br />
            {{ eventFaculty.name }}
            <br />
            {{ eventPlace.name }}
          </p>

          <!-- Available tickets -->
          <div
            class="number-of-tickets"
            style="margin-top: 10px; background-color: #e6e6e6; color: #454545;"
          >
            <b-icon icon="account"></b-icon>
            <strong style="padding-left: 5px;">LIMIT MIEST:</strong>

            <span v-if="eventAttendanceLimit >= 1">
              <i>{{ eventAttendanceLimit }}</i>
            </span>

            <span v-else>
              <i>Neobmedzene</i>
            </span>
          </div>

          <!-- TODO -->
          <div>
            <a @click.prevent="downloadItem(item)">Stiahnuť pdf</a>
          </div>

          <!-- Sign up button -->
          <div>
            <b-button
              v-bind:class="{
                eventBackColorFPV: eventIdFaculty == 1,
                eventBackColorFF: eventIdFaculty == 4,
                eventBackColorFSS: eventIdFaculty == 3,
                eventBackColorFP: eventIdFaculty == 5,
                eventBackColorFSVZ: eventIdFaculty == 2,
                eventBackColorUKF: eventIdFaculty == 6,
                eventBackColorLIB: eventIdFaculty == 7
              }"
              style="margin-top: 10px; margin-bottom: 10px; color: white;"
            >
              Prihlasit sa
            </b-button>
          </div>
        </div>

        <!-- Section 2 -->
        <div class="column is-4-desktop section2">
          <!-- Heading of section 2 -->
          <div class="section2-heading alignLeft">
            <b-icon icon="file-document-multiple-outline"></b-icon>
            <strong style="padding-left: 5px;">POPIS UDALOSTI</strong>
          </div>

          <!-- Category info -->
          <div
            class="alignRight categoryInfo"
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
            <div class="alignLeft">
              Kategoria |
            </div>

            <div class="alignRight">
              <b-icon icon="apps"></b-icon>
            </div>

            <div style="clear: both;"></div>
          </div>

          <div style="clear: both;"></div>

          <!-- Separator line -->
          <hr class="separator-line" />

          <!-- Event details -->
          <div class="event-details" v-repeat="10">
            {{ eventDesc }}
          </div>
        </div>

        <!-- Section 3 -->
        <div class="column is-2-desktop section3">
          <!-- Heading of section 2 -->
          <div class="section2-heading">
            <b-icon icon="image-outline"></b-icon>
            <strong style="padding-left: 5px;">GALERIA</strong>
          </div>

          <!-- Separator line -->
          <hr class="separator-line-section-4" />

          <!-- Event gallery -->
          <div class="event-image-gallery">
            <div v-if="images">
              <img
                v-for="image in images"
                :key="image"
                :src="getImgUrl(image)"
                class="imageLink"
                @click="
                  isImageModalActive = true;
                  imageModal = image;
                "
              />
              <b-modal v-model="isImageModalActive">
                <p class="image">
                  <img :src="getImgUrl(imageModal)" />
                </p>
              </b-modal>
            </div>
          </div>
        </div>

        <!-- Section 4 -->
        <div class="column is-3-desktop section4 eventDetailsHeaderColor">
          <div class="map-container">
            <h1
              style="font-weight: bold; color: white; margin-left: 150px; margin-top: 90px;"
            >
              Map
            </h1>
          </div>

          <!-- Other details about the event -->
          <div class="other-details">
            <div class="forLabel">
              URCENE PRE
              <b-icon icon="school"></b-icon>
            </div>

            <div class="by">
              {{ eventFaculty.name }}
              <br />
              <span style="font-weight: normal;" v-if="eventDepartment">
                {{ eventDepartment.name }}
              </span>

              <span v-else style="font-weight: normal;">
                Vsetky katedry
              </span>
            </div>

            <br />

            <div class="forLabel">
              VYTVORIL
              <b-icon icon="account"></b-icon>
            </div>

            <div class="by">{{ eventUser.name }} {{ eventUser.surname }}</div>

            <br />

            <!-- Bulma dropdown for adding to the calendar -->
            <!-- TODO: have to fix the not overflowing thing -->
            <b-dropdown aria-role="list" style=" overflow: visible;">
              <button
                class="button"
                slot="trigger"
                v-bind:class="{
                  eventBackColorFPV: eventIdFaculty == 1,
                  eventBackColorFF: eventIdFaculty == 4,
                  eventBackColorFSS: eventIdFaculty == 3,
                  eventBackColorFP: eventIdFaculty == 5,
                  eventBackColorFSVZ: eventIdFaculty == 2,
                  eventBackColorUKF: eventIdFaculty == 6,
                  eventBackColorLIB: eventIdFaculty == 7
                }"
                style="color: white;"
                slot-scope="{ active }"
              >
                <span>Pridat do kalendara</span>
                <b-icon :icon="active ? 'menu-up' : 'menu-down'"></b-icon>
              </button>

              <b-dropdown-item aria-role="listitem" style="overflow-y: auto;">
                Action
              </b-dropdown-item>
            </b-dropdown>
          </div>
        </div>
      </div>
    </article>
  </div>
</template>

<script>
let months = [
  "január",
  "február",
  "marec",
  "apríl",
  "máj",
  "jún",
  "júl",
  "august",
  "september",
  "október",
  "november",
  "december"
];
import httpClient from "../../httpClient.js";

export default {
  name: "EventDetailsComponent",

  // Registering the components
  components: {},

  methods: {
    getYear() {
      return this.eventBeginning.substr(0, this.eventBeginning.indexOf("-"));
    },

    getMonth() {
      let month_id = parseInt(
        this.eventBeginning.substr(5, this.eventBeginning.indexOf("-") - 2)
      );
      return months[month_id - 1];
    },

    getDay() {
      return this.eventBeginning.substr(8, this.eventBeginning.length - 17);
    },

    goBack() {
      this.$router.go(-1);
    },
    downloadItem() {
      httpClient
        .get(`/files/pdf/${this.eventId}`)
        .then(response => {
          const pdf = response.data.pdfs.pdf1;
          const link = document.createElement("a");
          link.href = `data:application/pdf;base64,${pdf}`;
          link.download = response.data.pdfs_path.pdf1_path;
          link.click();
        })
        .catch(console.error);
    },
    getImgUrl(value) {
      return process.env.VUE_APP_IMAGES_STORAGE_URL + value;
    }
  },
  data() {
    return {
      // Default map location
      center: {
        lat: 40.73061,
        lng: -73.935242
      },
      images: [],
      imageModal: null,
      isImageModalActive: false,
      isCardModalActive: false,
      imageGalleryLink:
        "https://journavel.com/wp-content/uploads/2014/10/img-placeholder-dark.jpg"
    };
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
    }
  },
  computed: {
    eventDateSplit: function() {
      return this.eventBeginning.substr(0, this.eventBeginning.indexOf(" "));
    },

    eventTimeSplit: function() {
      return this.eventBeginning.substr(this.eventBeginning.indexOf(" ") + 1);
    }
  },
  created() {
    this.$store.commit("pushToLoading", "EventDetailsLoadImages");
    httpClient
      .get(`/files/image/${this.eventId}`)
      .then(response => {
        this.images = response.data.images_path;
        this.$store.commit("finishLoading", "EventDetailsLoadImages");
      })
      .catch(() => {
        this.$store.commit("finishLoading", "EventDetailsLoadImages");
      });
  }
};
</script>

<style lang="scss" scoped>
.alignLeft {
  float: left !important;
}

.alignRight {
  float: right !important;
}

.message {
  margin-bottom: 20px;
  width: auto;
  margin-left: 28px;
  margin-right: 28px;
  border-radius: 10px;
  -webkit-box-shadow: 0px 18px 42px -17px rgba(0, 0, 0, 0.74);
  -moz-box-shadow: 0px 18px 42px -17px rgba(0, 0, 0, 0.74);
  box-shadow: 0px 18px 42px -17px rgba(0, 0, 0, 0.74);

  .message-header {
    color: white;
  }

  .message-body {
    text-align: justify;
    font-size: medium;
  }
}

._card {
  padding: 0px;
  border-radius: 10px;
  -webkit-box-shadow: 0px 18px 42px -17px rgba(0, 0, 0, 0.74);
  -moz-box-shadow: 0px 18px 42px -17px rgba(0, 0, 0, 0.74);
  box-shadow: 0px 18px 42px -17px rgba(0, 0, 0, 0.74);
}

.section4-card {
  padding: 0px;
  margin-left: 28px;
  margin-right: 28px;
  border-radius: 5px;
  -webkit-box-shadow: 0px 10px 54px -32px rgba(0, 0, 0, 0.75);
  -moz-box-shadow: 0px 10px 54px -32px rgba(0, 0, 0, 0.75);
  box-shadow: 0px 10px 54px -32px rgba(0, 0, 0, 0.75);
}

.eventTags {
  padding-top: 10px;
  padding-bottom: 10px;
}

.columns {
  margin: 0px;
  text-align: justify;

  .section1 {
    padding-left: 20px;
    border-bottom-left-radius: 5px;

    .number-of-tickets {
      color: white;
      width: max-content;
      padding: 5px 10px 5px 10px;
      border-radius: 8px;
    }
  }

  .section2 {
    font-size: medium;
    padding: 20px;

    .section2-heading {
      padding-top: 3px;
      font-size: 26px;
    }

    .categoryInfo {
      color: white;
      width: max-content;

      padding-left: 10px;
      padding-right: 10px;
      padding-top: 5px;

      margin-top: 5px;
      border-radius: 5px;
      font-weight: bold;
    }

    .event-details {
      height: 325px;
      overflow-y: scroll;
      padding: 8px 15px 8px 8px;
    }
  }

  .section3 {
    background: white;

    .event-image-gallery {
      height: 345px;
      overflow-y: scroll;
      padding-right: 5px;
    }
  }

  .section4 {
    margin: 0px;
    border-bottom-right-radius: 5px;
    font-size: medium;
    clear: both;
    overflow: hidden;
    padding-left: 15px;
    padding-top: 15px;

    .map-container {
      clear: both;
      overflow: hidden;
      width: 100%;
      height: 200px;
      border: 1px solid #b3b3b3;
      border-radius: 5px;
      margin-bottom: 10px;
      background-color: #000000;
    }

    .other-details {
      font-size: small;

      .forLabel {
        font-weight: bold;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
      }

      .by {
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
      }
    }
  }
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
  background: #f31a33;
}

.eventDetailsHeaderColor {
  background: #ededed;
}

.row {
  display: flex;
  flex-wrap: wrap;
  padding: 0 4px;
}

.imageLink {
  cursor: pointer;
}

.section4-separator-line {
  margin-top: 5px;
  margin-bottom: 5px;
  background: #d1d1d1;
  height: 1px;
  width: auto;
}

.separator-line {
  margin-top: 10px;
  margin-bottom: 10px;
  background: #d1d1d1;
  height: 1px;
  width: 100%;
}

.separator-line-section-4 {
  margin-top: 15px;
  margin-bottom: 15px;
  background: #d1d1d1;
  height: 1px;
  width: 100%;
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
</style>
