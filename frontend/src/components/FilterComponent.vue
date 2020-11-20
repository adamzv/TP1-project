<template>
  <div class="container is-fluid filterPanel">

    <!-- This was the only way I could make it work, too much time spent, had to compromise for sanity reasons. -->
    <!-- Maybe modularize this in the future somehow so it looks cleaner -->
    <!-- Filter view for mobile screen sizes  -->

    <div v-if="showMobile && !showDesktop">
      <b-collapse aria-id="contentIdForA11y2"
                  class="panel collapse"
                  animation="slide"
                  v-model="isOpen"
                  :open="isOpen = false">

        <div slot="trigger"
             class="panel-heading filterHeading"
             role="button"
             v-if="windowWidth <= 768"
             aria-controls="contentIdForA11y2">

            <div @click="addOpenIndex()" class="mobile-filter-trigger">
                <div style="padding-left: 35px;" v-if="windowWidth <= 768">
                    <b-icon icon="filter" size="is-medium"></b-icon>

                    <h1 class="mobile-filter-trigger-icon">
                        <b-icon icon="chevron-down"
                                size="is-medium"
                                v-if="openIndex % 2 == 0">
                        </b-icon>
                        <b-icon icon="chevron-up"
                                size="is-medium"
                                v-else>
                        </b-icon>
                    </h1>
                </div>
            </div>
        </div>

        <div class="panel-block filterBlock">
          <div class="columns columnsPos">
            <div class="column filterItem">
              <b-input v-model="eventName"
                       field="name"
                       placeholder="Názov">
              </b-input>
            </div>

            <div class="column filterItem">
              <b-datetimepicker v-model="beginning"
                                icon="calendar-today"
                                :locale="'sk-SK'"
                                ref="datepicker"
                                placeholder="Dátum konania"
                                horizontal-time-picker>

                <template slot="left">
                  <b-button disabled style="visibility:hidden"></b-button>
                </template>

                <template slot="right">
                  <b-button outlined
                            class="button is-success"
                            type="button"
                            icon-left="check"
                            @click="$refs.datepicker.toggle()"
                  ></b-button>
                </template>
              </b-datetimepicker>
            </div>

            <div class="column">
              <b-button style="color: white; width: 100%;"
                        class="button"
                        type="is-danger"
                        icon-left="delete-outline"
                        @click="beginning = null"
              ></b-button>
            </div>

            <div class="column filterItem">
              <b-taginput v-model="categories"
                          :data="filteredCategories"
                          field="name"
                          autocomplete
                          :allow-new="false"
                          :open-on-focus="true"
                          :keep-first="true"
                          icon="label"
                          placeholder="Kategórie"
                          @typing="getFilteredTags">

              </b-taginput>
            </div>

            <div class="column filterItem">
              <b-autocomplete v-model="selectedFacultyName"
                              :keep-first="true"
                              :open-on-focus="true"
                              placeholder="Fakulta"
                              :data="availableFaculties"
                              field="name"
                              @select="option => (selectedFaculty = option)"
                              v-on:select="checkIfDepartmentIsSelected"
                              :clearable="true">
              </b-autocomplete>
            </div>

            <div class="column filterItem">
              <b-autocomplete v-model="selectedDepartmentName"
                              :keep-first="true"
                              :open-on-focus="true"
                              :data="getFilteredDepartments"
                              field="name"
                              :disabled="selectedFaculty == null"
                              placeholder="Katedra"
                              :clearable="true">
              </b-autocomplete>
            </div>

            <div class="column filterItem">
              <b-autocomplete v-model="placeName"
                              ref="autocomplete"
                              :data="availablePlaces"
                              field="name"
                              :keep-first="true"
                              :open-on-focus="true"
                              :clearable="true"
                              placeholder="Miesto konania"
                              @select="option => (place = option)">

                <template slot="header">
                  <a @click="console.log('todo')">
                    <span>Pridať nové miesto</span>
                  </a>
                </template>
              </b-autocomplete>
            </div>
          </div>
        </div>

        <div style="padding-right: 35px;"
             v-if="windowWidth <= 768">

          <div class="level-right filterButton"
               style=" padding-bottom: 2px; padding-left: 12px;">

            <b-button class="level-item is-info"
                      icon-left="filter"
                      style="width: 100%;"
                      @click="sendDataToParent()">
              Filtrovať
            </b-button>
          </div>
        </div>
      </b-collapse>
    </div>

    <!-- Filter view for desktop and tablet screen sizes  -->
    <div v-else-if="!showMobile && showDesktop">
      <b-collapse
              aria-id="contentIdForA11y2"
              class="panel collapse"
              animation="slide"
              v-model="isOpen"
              :open="isOpen = true">

        <div class="panel-block filterBlock">
          <b-icon icon="filter"
                  class="desktop-filter-icon"
                  size="is-large"
                  v-if="windowWidth > 1840">
          </b-icon>

          <div class="columns columnsPos">
            <div class="column filterItem">
              <b-input v-model="eventName"
                       field="name"
                       placeholder="Názov">
              </b-input>
            </div>

            <div class="column filterItem">
              <b-datetimepicker v-model="beginning"
                                icon="calendar-today"
                                :locale="'sk-SK'"
                                ref="datepicker"
                                placeholder="Od dátumu konania"
                                horizontal-time-picker>

                <template slot="left">
                  <b-button disabled style="visibility:hidden"></b-button>
                </template>

                <template slot="right">
                  <b-button outlined
                            class="button is-success"
                            type="button"
                            icon-left="check"
                            @click="$refs.datepicker.toggle()"
                  ></b-button>
                </template>
              </b-datetimepicker>
            </div>

            <b-button outlined
                      class="button btn-desktop-remove-date"
                      type="button"
                      icon-left="delete-outline"
                      @click="beginning = null"
            ></b-button>

            <div class="column filterItem">
              <b-taginput v-model="categories"
                          :data="filteredCategories"
                          field="name"
                          autocomplete
                          :allow-new="false"
                          :open-on-focus="true"
                          :keep-first="true"
                          icon="label"
                          placeholder="Kategórie"
                          @typing="getFilteredTags">
              </b-taginput>
            </div>

            <div class="column filterItem">
              <b-autocomplete v-model="selectedFacultyName"
                              :keep-first="true"
                              :open-on-focus="true"
                              placeholder="Fakulta"
                              :data="availableFaculties"
                              field="name"
                              @select="option => (selectedFaculty = option)"
                              v-on:select="checkIfDepartmentIsSelected"
                              :clearable="true">
              </b-autocomplete>
            </div>

            <div class="column filterItem">
              <b-autocomplete v-model="selectedDepartmentName"
                              :keep-first="true"
                              :open-on-focus="true"
                              :data="getFilteredDepartments"
                              field="name"
                              :disabled="selectedFaculty == null"
                              placeholder="Katedra"
                              :clearable="true">
              </b-autocomplete>
            </div>

            <div class="column filterItem">
              <b-autocomplete v-model="placeName"
                              ref="autocomplete"
                              :data="availablePlaces"
                              field="name"
                              :keep-first="true"
                              :open-on-focus="true"
                              :clearable="true"
                              placeholder="Miesto konania"
                              @select="option => (place = option)">

                <template slot="header">
                  <a @click="console.log('todo')">
                    <span>Pridať nové miesto</span>
                  </a>
                </template>
              </b-autocomplete>
            </div>

            <div class="column" style="text-align: right;"
                 v-if="windowWidth <= 1840 && windowWidth > 768">

              <b-button class="is-outlined is-info"
                        icon-left="filter"
                        style="width: auto !important;"
                        @click="sendDataToParent()">
                Filtrovať
              </b-button>
            </div>

            <div>
              <div class="level-right filterButton" align="right"
                   style="position: absolute; right: 35px;">

                <b-button class="level-item is-outlined is-info"
                          icon-left="filter"
                          @click="sendDataToParent()"
                          v-if="windowWidth > 1840">
                  Filtrovať
                </b-button>
              </div>
            </div>
          </div>
        </div>
      </b-collapse>
    </div>
  </div>
</template>

<script>
  import httpClient from "../httpClient";

  const MOBILE_SIZE = 768;
  const CHECK_INTERVAL = 10;

  export default {
    data() {
      return {
        filteredEvents: [],
        isOpen: true,
        windowWidth: window.innerWidth,
        showDesktop: true,
        showMobile: false,
        openIndex: 0,

        eventName: "",
        availableCategories: [],
        filteredCategories: [],
        id: null,
        name: "",
        desc: null,
        categories: [],
        beginning: null,
        place: null,
        availablePlaces: [],
        selectedDepartment: null,
        selectedFaculty: null,
        availableDepartments: [],
        availableFaculties: [],
        response: null,
        placeName: "",
        selectedDepartmentName: "",
        selectedFacultyName: "",
      };
    },

    methods: {
      checkScreenSize () {
        this.windowWidth = window.innerWidth;

        if (this.windowWidth <= MOBILE_SIZE) {
          this.showMobile = true;
          this.showDesktop = false;
        } else if (this.windowWidth > MOBILE_SIZE) {
          this.showDesktop = true;
          this.showMobile = false;
          this.isOpen = true;
        }

        console.log(this.$store.getters.getCurrentlyInFilter)
      },

      addOpenIndex() {
          this.openIndex++;
      },

      getFilteredTags(text) {
        this.filteredCategories = this.availableCategories.filter(option => {
          return (
                  option.name
                          .toString()
                          .toLowerCase()
                          .indexOf(text.toLowerCase()) >= 0
          );
        });
      },

      checkIfDepartmentIsSelected() {
        if (this.selectedFaculty == null && this.selectedDepartment !== null) {
          this.selectedDepartment = null;
        }
      },

      sendDataToParent() {
        this.createFilterRequest();
      },

      getRequestFilteredEvents(apiUrl) {
        httpClient.get(apiUrl)
          .then(response => {
            this.$store.commit('setCurrentlyInFilter', response.data);
            this.$store.commit('setURL_API_FILTER', apiUrl)

            this.$emit('clicked', {
              'filteredEvents': response.data
            });
          });
      },

      createFilterRequest() {
        if (this.eventName != null && this.selectedFaculty == null) {
          this.getRequestFilteredEvents(`/events?filter=name=${this.eventName}`);
        } else if (this.eventName == null && this.selectedFaculty != null) {
          this.getRequestFilteredEvents(`/events?filter=id_faculty=${this.selectedFaculty.id}`);
        } else {
          this.getRequestFilteredEvents(`/events?filter=name=${this.eventName},id_faculty=${this.selectedFaculty.id}`);
        }
      }
    },

    computed: {
      getFilteredDepartments() {
        return this.availableDepartments.filter(department => {
          return (
                  this.selectedFaculty !== null &&
                  department.id_faculty === this.selectedFaculty.id
          );
        });
      },
    },

    created() {
      window.setInterval(() => { this.checkScreenSize(); }, CHECK_INTERVAL);

      // loads categories from backend
      httpClient.get("/categories").then(response => {
        this.availableCategories = response.data;
        this.filteredCategories = response.data;
      });

      httpClient.get("/places").then(response => {
        this.availablePlaces = response.data;
      });

      httpClient.get("/departments").then(response => {
        this.availableDepartments = response.data;
      });

      httpClient.get("/faculties").then(response => {
        this.availableFaculties = response.data;
      });
    }
  };
</script>

<style>
  .container {
    margin-top: 24px;
    padding: 0 0 !important;
    text-align: left;
  }

  .filter {
    background: rgb(219,219,219);
    background: linear-gradient(0deg, rgba(219,219,219,1) 0%, rgba(241,241,241,1) 100%);
  }

  .level-item {
    margin: 12px 12px;
  }

  .filterHeading {
    text-align: left;
  }

  .filterPanel {
    width: 100%;
      border-bottom-right-radius: 5px;
      border-bottom-left-radius: 5px;
  }

  .columnsPos {
    width: 1560px; margin: 0 auto !important;
  }

  .btn-desktop-remove-date {
    margin-top: 12px;
    margin-left: -15px;
    height: 40px;
    border-top-left-radius: 0px !important;
    border-bottom-left-radius: 0px !important;;
    color: #737373;
  }

  .desktop-filter-icon {
    position: absolute;
    margin-left: 60px;
    color: #525252;
  }

  .mobile-filter-trigger {
    margin: -10px;
    color: #525252;
    padding-top: 6px;
    padding-bottom: 6px;
  }

  .mobile-filter-trigger-icon {
    display: inline-block;
    float: right;
    padding-right: 37px;
  }

  @media screen and (max-width: 1547px) {
    .filterPanel {
      width: 100% !important;
    }
  }

  @media screen and (max-width: 768px) {
    .filterButton {
      width: 100%;
    }
  }
</style>
