/* * * Created by: Martin Gajdos * Date: 26. 10. 2020 * * Description: This
component takes in data from EventListComponent and renders them in a * detailed
format. * */

<template>
  <div style="max-width: 1500px; margin: 0 auto;">
    <!-- Actual card -->
    <article class="_card message is-medium">
      <!-- Card header -->
      <div class="message-header">
        <p>Kerierny den</p>
        <button class="delete is-medium" aria-label="delete"></button>
      </div>

      <!-- Individual sections of the card -->
      <div class="columns">
        <!-- Section 1 -->
        <div class="column is-3-desktop section1">
          <!-- Event tags -->
          <div class="eventTags">
            <div class="tagsSection">
              <!-- Select a background color based off of the faculty -->
              <div class="tags">
                <!-- Actual tags -->
                <b-button rounded size="is-small">
                  #tag
                </b-button>

                <!-- Actual tags -->
                <b-button rounded size="is-small">
                  #tag
                </b-button>

                <!-- Actual tags -->
                <b-button rounded size="is-small">
                  #tag
                </b-button>
              </div>
            </div>
          </div>

          <!-- Seperator line -->
          <hr class="separator-line" />

          <div>
            <b-icon icon="clock-time-four-outline"></b-icon>
            <strong style="padding-left: 5px;">KEDY</strong>
          </div>

          <p style="font-size: medium; padding-top: 10px;">
            21. decembra 2020 12:30
          </p>

          <div style="padding-top: 10px;">
            <b-icon icon="map-marker"></b-icon>
            <strong style="padding-left: 5px;">KDE</strong>
          </div>

          <p style="font-size: medium; padding-top: 10px;">
            Miestnosť P-2
            <br />
            Fakulta prírodných vied
            <br />
            Univerzita Konštantína Filozofa v Nitre
            <br />
            Tr. A. Hlinku 1, 949 01 Nitra
          </p>

          <!-- Separator line -->
          <hr class="separator-line" />

          <!-- Available tickets -->
          <div class="number-of-tickets">
            <b-icon icon="account"></b-icon>
            <strong style="padding-left: 5px;">POCET MIEST:</strong>
            <i>5/100</i>
          </div>

          <!-- Sign up button -->
          <div>
            <b-button
              type="is-info"
              style="margin-top: 10px; margin-bottom: 10px;"
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
          <div class="alignRight categoryInfo">
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
            {{ eventDetailsTest }}
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
            <img
              @click="isImageModalActive = true"
              :src="imageGalleryLink"
              class="imageLink"
            />
            <img
              @click="isImageModalActive = true"
              :src="imageGalleryLink"
              class="imageLink"
            />
            <img
              @click="isImageModalActive = true"
              :src="imageGalleryLink"
              class="imageLink"
            />
            <img
              @click="isImageModalActive = true"
              :src="imageGalleryLink"
              class="imageLink"
            />
            <img
              @click="isImageModalActive = true"
              :src="imageGalleryLink"
              class="imageLink"
            />
            <img
              @click="isImageModalActive = true"
              :src="imageGalleryLink"
              class="imageLink"
            />
            <img
              @click="isImageModalActive = true"
              :src="imageGalleryLink"
              class="imageLink"
            />
            <img
              @click="isImageModalActive = true"
              :src="imageGalleryLink"
              class="imageLink"
            />

            <b-modal v-model="isImageModalActive">
              <p class="image">
                <img :src="imageGalleryLink" />
              </p>
            </b-modal>
          </div>
        </div>

        <!-- Section 4 -->
        <div class="column is-3-desktop section4">
          <div class="map-container">
            <HereMap
              :center="center"
              style="width: 100%; height: 200px; overflow: hidden; margin: 0px;"
            />
          </div>

          <!-- Other details about the event -->
          <div class="other-details">
            <div class="forLabel">
              URCENE PRE
              <b-icon icon="school"></b-icon>
            </div>

            <!-- Separator line -->
            <hr class="section4-separator-line" />

            <div class="by">
              Fakulta prirodnych vied
              <br />
              <span style="font-weight: normal;">
                <i>Katedra informatiky</i>
              </span>
            </div>

            <div class="forLabel">
              VYTVORIL
              <b-icon icon="account"></b-icon>
            </div>

            <!-- Separator line -->
            <hr class="section4-separator-line" />

            <div class="by">
              RNDr. Miroslav Lukac, Ph.D.
            </div>

            <br />

            <!-- Bulma dropdown for adding to the calendar -->
            <!-- TODO: have to fix the not overflowing thing -->
            <b-dropdown aria-role="list">
              <button
                class="button is-info"
                slot="trigger"
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
// Importing Here Map
import HereMap from "../map/HereMap";

export default {
  name: "EventDetailsComponent",

  // Registering the components
  components: {
    HereMap
  },

  data() {
    return {
      // Default map location
      center: {
        lat: 40.73061,
        lng: -73.935242
      },

      isImageModalActive: false,
      isCardModalActive: false,
      imageGalleryLink:
        "https://journavel.com/wp-content/uploads/2014/10/img-placeholder-dark.jpg",
      eventDetailsTest:
        "Tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\n" +
        "                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\n" +
        "                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\n" +
        "                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\n" +
        "                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\n" +
        "                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\n" +
        "                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\n" +
        "                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.\n" +
        "                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\n" +
        "                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\n" +
        "                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\n" +
        "                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\n" +
        "                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam."
    };
  },

  // All the props regarding the event
  props: {
    eventId: {
      type: Number,
      required: true
    },
    eventName: {
      type: String,
      required: true
    },
    eventDesc: {
      type: String,
      required: true
    },
    eventDate: {
      type: String,
      required: true
    },
    eventTime: {
      type: String,
      required: true
    },
    eventPlace: {
      type: String,
      required: true
    },
    eventFaculty: {
      type: String,
      required: true
    },
    eventDepartment: {
      type: String,
      required: true
    },
    eventTags: {
      type: Array,
      required: true
    }
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
    background: #55c8d9;
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
  border-radius: 10px;
  -webkit-box-shadow: 0px 10px 54px -32px rgba(0, 0, 0, 0.75);
  -moz-box-shadow: 0px 10px 54px -32px rgba(0, 0, 0, 0.75);
  box-shadow: 0px 10px 54px -32px rgba(0, 0, 0, 0.75);
}

.eventTags {
  padding-top: 10px;
  padding-bottom: 10px;

  .button {
    margin-right: 5px;
    padding: 10px;
    opacity: 0.9;
  }

  .tags {
    padding: 5px;
    border-radius: 20px;
    margin: 0px;
    background: #96e5f1;
  }
}

.tagsSection {
  margin: 0;
  width: max-content;
}

.columns {
  margin: 0px;
  text-align: justify;

  .section1 {
    background: #d5f8fe;
    padding-left: 20px;
    border-bottom-left-radius: 8px;

    .number-of-tickets {
      background: #96e5f1;
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
      background: #96e5f1;
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
    background: #d5f8fe;
    border-bottom-right-radius: 8px;
    font-size: medium;
    clear: both;
    overflow: hidden;
    padding-left: 15px;
    padding-top: 15px;

    .map-container {
      clear: both;
      overflow: hidden;
      width: 100%;
      border: 1px solid #b3b3b3;
      border-radius: 5px;
      margin-bottom: 10px;
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