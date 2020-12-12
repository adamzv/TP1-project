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

          <div style="padding-top: 10px;">
            <b-icon icon="clock-time-four-outline"></b-icon>
            <strong style="padding-left: 5px;">KEDY</strong>
          </div>

          <p class="panel-info" style="font-size: small;">
            {{ getDay() }}. {{ getMonth() }} {{ getYear() }}

            <span class="panel-info-time" style="font-size: small;">
              {{ eventTimeSplit2() }}
            </span>
          </p>

          <div style="padding-top: 20px;">
            <b-icon icon="map-marker"></b-icon>
            <strong style="padding-left: 5px;">KDE</strong>
          </div>

          <p class="panel-info" style="font-size: small;">
            Miestnosť {{ eventRoom }}
            <br />
            {{ eventFaculty.name }}
            <br />
            {{ eventPlace.name }}
          </p>

          <div style="padding-top: 20px;">
            <b-icon icon="calendar"></b-icon>
            <strong style="padding-left: 5px;">KALENDÁR</strong>
          </div>

          <p class="panel-info">
            <b-tooltip position="is-bottom" label="Google">
              <a :href="google">
                <b-icon size="is-small" icon="google"></b-icon>
              </a>
            </b-tooltip>
            <b-tooltip position="is-bottom" label="Outlook">
              <a :href="outlook">
                <b-icon size="is-small" icon="microsoft-outlook"></b-icon>
              </a>
            </b-tooltip>
            <b-tooltip position="is-bottom" label="Office365">
              <a :href="office365">
                <b-icon size="is-small" icon="microsoft-office"></b-icon>
              </a>
            </b-tooltip>
            <b-tooltip position="is-bottom" label="iCalendar (.ics)">
              <a :href="ics">
                <b-icon size="is-small" icon="calendar"></b-icon>
              </a>
            </b-tooltip>
          </p>

          <div style="margin-top: 20px; margin-bottom: 10px;">
            <b-icon icon="account"></b-icon>
            <strong style="padding-left: 5px;">LIMIT MIEST</strong>

            <p
              v-if="eventAttendanceLimit >= 1"
              class="panel-info"
              style="font-size: small;"
            >
              <i>
                <span v-if="eventParticipants">{{ eventParticipants }} /</span>
                <span v-else>0 /</span>
                {{ eventAttendanceLimit }}
              </i>
            </p>

            <p v-else class="panel-info" style="font-size: small;">
              <i>Neobmedzene</i>
            </p>
          </div>

          <!-- Sign up button -->
          <div v-if="eventAttendanceLimit >= 1">
            <b-button
              v-if="!userAttendingEvent"
              @click="userAttendEvent()"
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
              Prihlásiť sa
            </b-button>
            <b-button
              v-if="userAttendingEvent"
              @click="userCancelAttendance()"
              type="is-danger"
              icon-right="close-thick"
              style="margin-top: 10px; margin-bottom: 10px; color: white;"
            >
              Odhlásiť sa
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
            <strong style="padding-left: 5px;">GALÉRIA</strong>
          </div>

          <!-- Separator line -->
          <hr class="separator-line-section-4" />

          <!-- Event gallery -->
          <div class="event-image-gallery">
            <div v-if="images">
              <img
                v-for="image in images"
                :key="image"
                :src="getThumbnailImgUrl(image)"
                class="imageLink"
                @click="(isImageModalActive = true), (imageModal = image)"
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
              URČENÉ PRE
              <b-icon icon="school"></b-icon>
            </div>

            <div class="by">
              {{ eventFaculty.name }}
              <br />
              <span style="font-weight: normal;" v-if="eventDepartment">
                {{ eventDepartment.name }}
              </span>

              <span v-else style="font-weight: normal;">
                Všetky katedry
              </span>
            </div>

            <br />

            <div class="forLabel">
              VYTVORIL
              <b-icon icon="account"></b-icon>
            </div>

            <div class="by">{{ eventUser.name }} {{ eventUser.surname }}</div>
            <br />

            <div v-if="eventPdf[0]">
              <b-button
                @click.prevent="downloadItem()"
                size="is-small"
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
                icon-right="download"
              >
                Stiahnuť informačný list
              </b-button>
            </div>
            <br />

            <div class="block">
              <ShareNetwork
                network="facebook"
                :url="eventURL"
                :title="eventName"
                :description="eventDesc"
                hashtags="ukf"
              >
                <b-icon class="facebook" icon="facebook"></b-icon>
              </ShareNetwork>
              <ShareNetwork
                network="twitter"
                :url="eventURL"
                :title="eventName"
                hashtags="ukf"
              >
                <b-icon class="twitter" icon="twitter"></b-icon>
              </ShareNetwork>
              <ShareNetwork network="reddit" :url="eventURL" :title="eventName">
                <b-icon class="reddit" icon="reddit"></b-icon>
              </ShareNetwork>
            </div>
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
import { google, outlook, office365, ics } from "calendar-link";

export default {
  name: "EventDetailsComponent",

  // Registering the components
  components: {},

  methods: {
    // TODO if user is logged in and is routed to details page,
    // then load information whether the user is attending the event
    userAttendEvent() {
      if (this.loggedInId) {
        httpClient
          .post(`/users/eventRegister`, {
            user_id: this.loggedInId,
            event_id: this.eventId
          })
          .then(response => {
            this.toastGenerator(response.data.message);
            this.eventParticipants = this.eventParticipants + 1;
          })
          .catch(error => {
            this.$buefy.toast.open({
              message: "Prihlásenie na udalosť bolo neúspešné.",
              type: "is-danger"
            });
            console.log(error);
          });
      } else {
        // if the user is not registered and wants to attend the event
        // then the user can register to the event using email address
        this.$buefy.dialog.prompt({
          message: "Napíšte email na prihlásenie",
          inputAttrs: {
            type: "email"
          },
          confirmText: "Prihlásiť sa",
          cancelText: "Zrušiť",
          trapFocus: true,
          onConfirm: email =>
            httpClient
              .post(`/users/eventRegister`, {
                email: email,
                event_id: this.eventId
              })
              .then(response => {
                this.toastGenerator(response.data.message);
              })
              .catch(error => {
                this.$buefy.toast.open({
                  message: "Prihlásenie na udalosť bolo neúspešné.",
                  type: "is-danger"
                });
                console.log(error);
              })
        });
      }
    },
    userCancelAttendance() {
      if (this.loggedInId && this.userAttendingEvent) {
        httpClient
          .post(`/users/eventUnregister`, {
            user_id: this.loggedInId,
            event_id: this.eventId
          })
          .then(response => {
            this.toastGenerator(response.data.message);
            this.eventParticipants = this.eventParticipants - 1;
          })
          .catch(error => {
            this.$buefy.toast.open({
              message: "Pokus o odhlásenie z udalosti bolo neúspešné.",
              type: "is-danger"
            });
            console.log(error);
          });
      }
    },
    toastGenerator(message) {
      if (message === "User was successfully removed from event") {
        this.$buefy.toast.open({
          message: `Boli ste odhlásený z  ${this.eventName}.`,
          type: "is-success"
        });
        this.userAttendingEvent = false;
      } else if (message === "Email sent") {
        this.$buefy.toast.open({
          duration: 3500,
          message: `Boli ste prihlásený na ${this.eventName}.<br />Do emailovej schránky Vám príde potvrdzovací email.`,
          type: "is-success"
        });
      } else if (message === "Please log in!") {
        this.$buefy.toast.open({
          message: `Na udalosť sa musíte prihlásiť svojim používateľským kontom.`,
          type: "is-warning"
        });
      } else if (message === "User was successfully registered on event") {
        // TODO if this is successful then send request
        // to retrieve event details number of registered users
        this.userAttendingEvent = true;
        this.$buefy.toast.open({
          message: `Boli ste prihlásený na ${this.eventName}.`,
          type: "is-success"
        });
      } else if (message === "Event Full") {
        this.$buefy.toast.open({
          message: "Všetky miesta sú už obsadené!",
          type: "is-danger"
        });
      } else if (message === "User is already registered on event") {
        this.$buefy.toast.open({
          message: `Už ste zaregistrovaná/ý na udalosť ${this.eventName}!`,
          type: "is-danger"
        });
      }
    },
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
    },
    getThumbnailImgUrl(value) {
      return process.env.VUE_APP_IMAGES_STORAGE_URL + "thumb-" + value;
    },
    eventTimeSplit2: function() {
      return this.eventBeginning.substr(this.eventBeginning.indexOf(" ") + 1);
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
        "https://journavel.com/wp-content/uploads/2014/10/img-placeholder-dark.jpg",
      userAttendingEvent: false,
      // calendar links
      google: "",
      outlook: "",
      office365: "",
      ics: ""
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
    },
    eventPdf: {
      type: Array,
      required: false
    },
    eventTitleImg: {
      type: Array,
      required: false
    },
    eventImages: {
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
    },
    loggedInId() {
      return this.$store.getters.loggedInId;
    },
    eventURL() {
      return window.location.href;
    }
  },
  created() {
    if (this.eventImages && this.eventImages.length > 0) {
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

    if (this.loggedInId) {
      this.$store.commit("pushToLoading", "EventDetailsUserState");
      httpClient
        .post("/users/checkEvent", {
          event_id: this.eventId,
          user_id: this.loggedInId
        })
        .then(response => {
          this.userAttendingEvent = response.data.message;
          this.$store.commit("finishLoading", "EventDetailsUserState");
        })
        .catch(() => {
          this.$store.commit("finishLoading", "EventDetailsUserState");
        });
    }
    var event = {
      title: this.eventName,
      description: this.eventDesc ? this.eventDesc : "",
      start: this.eventBeginning,
      location: this.eventPlace.name
    };
    this.google = google(event);
    this.outlook = outlook(event).replace("&rru=addevent", "");
    this.office365 = office365(event);
    this.ics = ics(event);
  }
};
</script>

<style lang="scss" scoped>
.twitter:hover {
  color: #1da1f2 !important;
}
.facebook:hover {
  color: #4267b2;
}
.reddit:hover {
  color: #ff4500;
}
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

    .panel-info {
      font-size: medium;
      padding-top: 2px;
      padding-bottom: 2px;
      font-size: medium;
      padding-left: 6px;
      padding-right: 6px;
      margin-top: 10px;
      background: #e0e0e0;
      width: fit-content;
      border-radius: 10px 5px 10px 5px;
      -moz-border-radius: 10px 5px 10px 5px;
      -webkit-border-radius: 10px 5px 10px 5px;
      border: 0px solid #000000;
      -webkit-box-shadow: 0px 3px 3px 1px rgba(0, 0, 0, 0.11);

      -webkit-box-shadow: 0px 1px 4px 1px rgba(0, 0, 0, 0.18);
      -moz-box-shadow: 0px 1px 4px 1px rgba(0, 0, 0, 0.18);
      box-shadow: 0px 1px 4px 1px rgba(0, 0, 0, 0.18);
    }

    .panel-info-time {
      font-size: medium;
      color: white;
      font-size: small;
      padding-left: 4px;
      padding-right: 4px;
      background: #707070;
      width: fit-content;
      border-radius: 10px 5px 10px 5px;
      -moz-border-radius: 10px 5px 10px 5px;
      -webkit-border-radius: 10px 5px 10px 5px;
      border: 0px solid #000000;
      font-weight: normal;
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
  background: #b2b2b2;
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
