<template>
  <div class="panel">
    <div class="columns">
      <div class="column">
        <div class="field is-grouped">
          <div class="control is-expanded">
            <input
              class="input is-primary"
              v-model="filterEvent"
              @input="filter()"
            />
          </div>
        </div>
        <div class="height-container">
          <nav class="panel">
            <a
              class="panel-block"
              v-for="event in filteredEvents"
              :key="event.id"
              @click="selectEvent(event)"
              v-bind:class="{ 'is-active': event.id === lastEvent }"
            >
              <span class="panel-icon">
                <i class="mdi mdi-book" aria-hidden="true"></i>
              </span>
              {{ event.name }}
            </a>
          </nav>
        </div>
      </div>
      <div class="column is-three-quarters">
        <div class="box">
          <div v-if="getSelectedEvent">
            <h1 class="is-uppercase is-size-4">
              {{ getSelectedEvent.name }}
            </h1>
            <p v-if="getSelectedEvent.desc">{{ getSelectedEvent.desc }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
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
      filterEvent: ""
    };
  },
  created() {},
  watch: {
    events() {
      if (this.events.length > 0) {
        this.lastEvent = this.events[0].id;
        this.filteredEvents = this.events;
      }
    }
  },
  methods: {
    selectEvent(event) {
      this.lastEvent = event.id;
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
      console.log(this.events.find(event => event.id === this.lastEvent));
      return this.events.find(event => event.id === this.lastEvent);
    }
  }
};
</script>

<style>
.height-container {
  height: 400px;
  overflow-y: auto;
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
