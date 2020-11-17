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
            Pridať udalosť
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
          <div v-if="addEvent">
            <ManageEvent />
          </div>
          <div v-if="getSelectedEvent">
            <ManageEvent />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ManageEvent from "./ManageEvent.vue";

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
      (this.lastEvent = null), (this.addEvent = true);
    },
    selectEvent(event) {
      this.lastEvent = event.id;
      this.addEvent = false;
    },
    filter() {
      console.log(this.filterEvent);
      this.filteredEvents = this.events.filter(option => {
        return (
          option.name
            .toString()
            .toLowerCase()
            .indexOf(this.filterEvent.toLowerCase()) >= 0
        );
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
