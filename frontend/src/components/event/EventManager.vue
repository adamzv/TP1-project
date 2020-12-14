<template>
  <div class="block" style="margin-bottom: 24px;">
    <div class="columns">
      <div class="column">
        <nav class="panel">
          <div class="panel-block">
            <p class="control has-icons-left">
              <b-input
                placeholder="Search..."
                type="search"
                icon="magnify"
                icon-clickable
                v-model="filterEvent"
                @input="filter()"
              ></b-input>
            </p>
          </div>
          <a
            class="panel-block"
            v-bind:class="{ 'is-active': addEvent }"
            @click="addEventForm()"
          >
            <span class="panel-icon">
              <i class="mdi mdi-calendar-plus" aria-hidden="true"></i>
            </span>
            {{ $t("event.add_event") }}
          </a>
          <a
            class="panel-block"
            v-for="event in paginatedEvents"
            :key="event.id"
            @click="selectEvent(event)"
            v-bind:class="{ 'is-active': event.id === lastEvent }"
          >
            <span class="panel-icon">
              <i class="mdi mdi-calendar" aria-hidden="true"></i>
            </span>
            {{ event.name }}
          </a>
          <div class="panel-block">
            <hr />
            <b-pagination
              :total="total"
              v-model="current"
              :simple="isSimple"
              :per-page="perPage"
              :icon-prev="prevIcon"
              :icon-next="nextIcon"
              aria-next-label="Next page"
              aria-previous-label="Previous page"
              aria-page-label="Page"
              aria-current-label="Current page"
            ></b-pagination>
          </div>
        </nav>
      </div>
      <div class="column is-three-quarters">
        <div>
          <template v-if="addEvent">
            <ManageEvent />
          </template>
          <template v-if="getSelectedEvent">
            <ManageEvent :event="getSelectedEvent" />
          </template>
        </div>
      </div>
    </div>
    <div class="columns">
      <div class="column">
        <hr />
        <div class="box">
          <div class="columns">
            <div class="column">
              <h2 class="is-size-4">
                Generovanie reportov
              </h2>
            </div>
          </div>
          <div class="columns">
            <div class="column">
              <b-notification type="is-warning">
                Ak si nezvolíte časový rozsah tak sa vygeneruje zoznam so
                všetkými udalosťami.
              </b-notification>
            </div>
          </div>
          <div class="columns">
            <div class="column">
              <b-field label="Začiatok udalosti">
                <b-datetimepicker
                  v-model="beginning"
                  placeholder="Vybrať dátum a čas"
                  icon="calendar-today"
                  :locale="'sk-SK'"
                  ref="datepicker"
                  horizontal-time-picker
                >
                  <!-- A simple hack to display timepicker in the middle :) -->
                  <template slot="left">
                    <b-button disabled style="visibility:hidden"></b-button>
                  </template>
                  <template slot="right">
                    <b-button
                      outlined
                      class="button is-success"
                      type="button"
                      icon-left="check"
                      @click="$refs.datepicker.toggle()"
                    ></b-button>
                  </template>
                </b-datetimepicker>
              </b-field>
            </div>
            <div class="column">
              <b-field label="Koniec udalosti">
                <b-datetimepicker
                  v-model="end"
                  placeholder="Vybrať dátum a čas"
                  icon="calendar-today"
                  :locale="'sk-SK'"
                  ref="datepickerend"
                  horizontal-time-picker
                >
                  <!-- A simple hack to display timepicker in the middle :) -->
                  <template slot="left">
                    <b-button disabled style="visibility:hidden"></b-button>
                  </template>
                  <template slot="right">
                    <b-button
                      outlined
                      class="button is-success"
                      type="button"
                      icon-left="check"
                      @click="$refs.datepickerend.toggle()"
                    ></b-button>
                  </template>
                </b-datetimepicker>
              </b-field>
            </div>
          </div>
          <div class="columns">
            <div class="column">
              <div class="level">
                <div class="level-left"></div>
                <div class="level-right">
                  <div class="level-item">
                    <input
                      type="button"
                      @click="generateReport()"
                      class="button is-success"
                      value="Report udalostí (.pdf)"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import httpClient from "../../httpClient";
import ManageEvent from "./ManageEvent.vue";
import moment from "moment";

export default {
  components: {
    ManageEvent
  },
  props: {
    events: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      beginning: "",
      end: "",
      lastEvent: null,
      filteredEvents: [],
      filterEvent: "",
      addEvent: true,
      // pagination properties
      current: 1,
      perPage: 6,
      isSimple: true,
      prevIcon: "chevron-left",
      nextIcon: "chevron-right"
    };
  },
  created() {},
  watch: {
    events() {
      if (this.events.length > 0) {
        // this.lastEvent = this.events[0].id;
        this.filteredEvents = this.events;
      }
    }
  },
  methods: {
    addEventForm() {
      this.lastEvent = null;
      this.addEvent = true;
    },
    selectEvent(event) {
      this.lastEvent = event.id;
      this.addEvent = false;
    },
    filter() {
      this.filteredEvents = this.events.filter(option => {
        return (
          option.name
            .toString()
            .toLowerCase()
            .indexOf(this.filterEvent.toLowerCase()) >= 0
        );
      });
    },
    generateReport() {
      var request = {};
      if (this.beginning !== "") {
        request.beginning = moment(this.beginning).format(
          "YYYY-MM-DD HH:mm:ss"
        );
      }
      if (this.end !== "") {
        request.end = moment(this.end).format("YYYY-MM-DD HH:mm:ss");
      }
      httpClient.post("files/downloadPDF", request).then(response => {
        window.location.href =
          process.env.VUE_APP_IMAGES_STORAGE_URL + response.data.path;
      });
    }
  },
  computed: {
    getSelectedEvent() {
      return this.events.find(event => event.id === this.lastEvent);
    },
    total() {
      return this.filteredEvents.length;
    },
    paginatedEvents() {
      let pageNumber = this.current - 1;
      return this.filteredEvents.slice(
        pageNumber * this.perPage,
        (pageNumber + 1) * this.perPage
      );
    }
  }
};
</script>

<style>
.height-container {
  height: 400px;
  overflow-y: auto;
}

.box {
  background-color: transparent;
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
