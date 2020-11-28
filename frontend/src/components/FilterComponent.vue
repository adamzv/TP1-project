<template>
  <div class="container is-fluid filterPanel">

    <!-- This was the only way I could make it work, too much time spent, had to compromise for sanity reasons. -->
    <!-- Maybe modularize this in the future somehow so it looks cleaner -->
    <!-- Filter view for mobile screen sizes  -->

    <div v-if="showMobile && !showDesktop">
      <b-collapse aria-id="contentIdForA11y2"
                  class="panel collapse"
                  animation="fade"
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
                        @click="clearDateFilter">
                Vymazať dátum
              </b-button>
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

            <b-button class="level-item is-danger"
                      icon-left="delete-outline"
                      style="width: 100%;"
                      @click="clearFilter()">
              Vymazať filter
            </b-button>

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
                      @click="clearDateFilter">
            </b-button>

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

              <b-button class="is-danger filter-button2"
                        icon-left="delete-outline"
                        style="margin-right: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px;"
                        @click="clearFilter()">

              </b-button>

              <b-button class="is-info filter-button2"
                        icon-left="filter"
                        style="margin-left: 0px; border-top-left-radius: 0px; border-bottom-left-radius: 0px;"
                        @click="sendDataToParent()">

              </b-button>
            </div>

            <div>
              <div class="level-right filterButton" align="right"
                   style="position: absolute; right: 12px;">

                <b-button class="level-item is-danger filter-button"
                          icon-left="delete-outline"
                          @click="clearFilter()"
                          v-if="windowWidth > 1840"
                          style="margin-right: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px;">

                </b-button>

                <b-button class="level-item is-info filter-button"
                          icon-left="filter"
                          @click="sendDataToParent()"
                          v-if="windowWidth > 1840"
                          style="margin-left: 0px; border-top-left-radius: 0px; border-bottom-left-radius: 0px;">

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

      clearFilter() {
        httpClient.get(`/events`)
          .then(response => {
            this.$store.commit('setCurrentlyInFilter', response.data);
            this.$store.commit('setURL_API_FILTER', `/events`);

            this.$emit('clicked', {
              'filteredEvents': response.data
            });
          });

        this.setFilterOptionsClear();
        this.setFilterOptions();
      },

      getRequestFilteredEvents(apiUrl) {
        httpClient.get(apiUrl)
          .then(response => {
            this.$store.commit('setCurrentlyInFilter', response.data);
            this.$store.commit('setURL_API_FILTER', apiUrl);

            this.$emit('clicked', {
              'filteredEvents': response.data
            });
          });
      },

      generateCorrectDatetime() {
        var dateRaw = String(this.beginning);
        var year = dateRaw.substr(11, dateRaw.indexOf(' ') + 1);
        var month = this.getCorrectMonthFormat(dateRaw.substr(4, dateRaw.indexOf(' ')));
        var day = dateRaw.substr(8, dateRaw.indexOf(' ') - 1);
        var time = dateRaw.substr(16, 8);
        var date = year + "-" + month + "-" + day;

        var finalDate = date + " " + time;
        if (finalDate == "te() { [n-- Date() { [nativ" || finalDate == "-- " || finalDate == "")
          return "";
        else
          return finalDate;
      },

      nameFilterRequestPart(insertFilter) {
        if (insertFilter) {
            return `name=${this.eventName}`;
        } else {
            return `name=${this.eventName}`;
        }
      },

      dateFilterRequestPart(insertFilter, date) {
          if (insertFilter) {
              return `,beginning=${date}`;
          } else {
              return ``;
          }
      },

      facultyFilterRequestPart(insertFilter) {
          if (insertFilter) {
              return `,id_faculty=${this.selectedFaculty.id}`;
          } else {
              return ``;
          }
      },

      departmentFilterRequestPart(insertFilter, department_id) {
        if (insertFilter) {
            return `,id_department=${department_id}`;
        } else {
            return ``;
        }
      },

      buildRequest() {
        // Get datetime and department id in a correct format
        var apiDate = this.generateCorrectDatetime();
        var apiDept = this.getDepId(this.selectedDepartmentName);

        var isName = this.eventName != "";
        var isDate = apiDate != "";
        var isFaculty = this.selectedFaculty != null;
        var isDepartment = apiDept != "";
        var arrayOfData = [false, false, false, false];

        // todo: add filtering based on categories and place
        if (isName)       { arrayOfData[0] = true; } else { arrayOfData[0] = false; }
        if (isDate)       { arrayOfData[1] = true; } else { arrayOfData[1] = false; }
        if (isFaculty)    { arrayOfData[2] = true; } else { arrayOfData[2] = false; }
        if (isDepartment) { arrayOfData[3] = true; } else { arrayOfData[3] = false; }

        var doFilterName = arrayOfData[0];
        var doFilterDate = arrayOfData[1];
        var doFilterFaculty = arrayOfData[2];
        var doFilterDepartment = arrayOfData[3];

        var request = `/events?filter=${this.nameFilterRequestPart(doFilterName)}${this.dateFilterRequestPart(doFilterDate, apiDate)}${this.facultyFilterRequestPart(doFilterFaculty)}${this.departmentFilterRequestPart(doFilterDepartment, apiDept)}`;
        this.getRequestFilteredEvents(request);
        console.log(request);
      },

      createFilterRequest() {
        this.setFilterOptions();
        this.buildRequest();
      },

      getCorrectMonthFormat(dateRaw) {
        let correctDateFormat = "";

        switch (dateRaw) {
          case "Jan": correctDateFormat = "01"; break;
          case "Feb": correctDateFormat = "02"; break;
          case "Mar": correctDateFormat = "03"; break;
          case "Apr": correctDateFormat = "04"; break;
          case "May": correctDateFormat = "05"; break;
          case "Jun": correctDateFormat = "06"; break;
          case "Jul": correctDateFormat = "07"; break;
          case "Aug": correctDateFormat = "08"; break;
          case "Sep": correctDateFormat = "09"; break;
          case "Oct": correctDateFormat = "10"; break;
          case "Nov": correctDateFormat = "11"; break;
          case "Dec": correctDateFormat = "12"; break;
        }

        return correctDateFormat;
      },

      getDepId(depRaw) {
        let depId = "";

        switch (depRaw) {
          case "Katedra zoológie a antropológie": depId = 1; break;
          case "Katedra chémie": depId = 2; break;
          case "Gemologický ústav": depId = 3; break;
          case "Katedra informatiky": depId = 4; break;
          case "Katedra matematiky": depId = 6; break;
          case "Katedra geografie a regionálneho rozvoja": depId = 7; break;
          case "Katedra fyziky": depId = 8; break;
          case "Katedra ekológie a enviromentalistiky": depId = 9; break;
          case "Katedra botaniky a genetiky": depId = 10; break;
          case "Katedra sociálnej práce asociálnych vied": depId = 11; break;
          case "Ústav aplikovanej psychológie": depId = 12; break;
          case "Ústav romologických štúdií": depId = 13; break;
          case "Katedra ošetrovateľstva": depId = 14; break;
          case "Katedra klinických disciplín aurgentnej medicíny": depId = 15; break;
          case "Katedra cestovného ruchu": depId = 16; break;
          case "Ústav maďarskej jazykovedy a literárnej vedy": depId = 17; break;
          case "Ústav pre vzdelávanie pedagógov": depId = 18; break;
          case "Ústaav stredoeurópskych jazykov a kultúr": depId = 19; break;
          case "Katedra anglistiky a amerikanistiky": depId = 20; break;
          case "Katedra archeológie": depId = 21; break;
          case "Katedra etnológie a folkloristiky": depId = 22; break;
          case "Katedra filozofie": depId = 23; break;
          case "Katedra germanistiky": depId = 24; break;
          case "Katedra histórie": depId = 25; break;
          case "Katedra kulturológie": depId = 26; break;
          case "Katedra manažmentu kultúry a turizmu": depId = 27; break;
          case "Katedra masmediálnej komunikácie a reklamy": depId = 28; break;
          case "Katedra muzeológie": depId = 29; break;
          case "Katedra náboženských štúdií": depId = 30; break;
          case "Katedra politológie a euroázijských štúdií": depId = 31; break;
          case "Katedra romanistiky": depId = 32; break;
          case "Katedra rusistiky": depId = 33; break;
          case "Katedra sociológie": depId = 34; break;
          case "Katedra translatológie": depId = 35; break;
          case "Katedra všeobecnej a aplikovanej etiky": depId = 36; break;
          case "Katedra žurnalistiky": depId = 37; break;
          case "Mediálne centrum": depId = 38; break;
          case "Tlmočnícky ústav": depId = 39; break;
          case "Ústav literárnej a umeleckej komunikácie": depId = 41; break;
          case "Ústav pre výskum kultúrneho dedičstva Konštantína a Metoda": depId = 42; break;
          case "Centrum digitálnych humanitných vied": depId = 43; break;
          case "Jazykové centrum": depId = 44; break;
          case "Katedra hudby": depId = 45; break;
          case "Katedra lingvodidaktiky a interkultúrnych štúdií": depId = 46; break;
          case "Katedra pedagogiky": depId = 47; break;
          case "Katedra pedagogickej a školskej psychológie": depId = 48; break;
          case "Katedra techniky a informačných technológií": depId = 49; break;
          case "Katedra telesnej výchovy a športu": depId = 50; break;
          case "Katedra výtvarnej tvorby a výchovy": depId = 51; break;
        }

        return depId;
      },

      retrieveFilterOptions() {
        this.eventName = this.$store.getters.getFilterEventName;
        this.beginning = this.$store.getters.getFilterBeginning;
        //this.eventCategories = this.$store.getters.getFilterCategories;
        this.selectedFacultyName = this.$store.getters.getFilterFaculty;
        this.selectedDepartmentName = this.$store.getters.getFilterDepartment;
        this.placeName = this.$store.getters.getFilterPlace;
      },

      setFilterOptions() {
        this.$store.commit('setFilterEventName', this.eventName);
        this.$store.commit('setFilterBeginning', this.beginning);
        this.$store.commit('setFilterFaculty', this.selectedFacultyName);
        this.$store.commit('setFilterDepartment', this.selectedDepartmentName);
        this.$store.commit('setFilterPlace', this.placeName);
      },

      setFilterOptionsClear() {
        this.eventName = "";
        this.beginning = "";
        //this.eventCategories = this.$store.getters.getFilterCategories;
        this.selectedFacultyName = "";
        this.selectedDepartmentName = "";
        this.placeName = "";
      },

      clearDateFilter() {
        this.beginning = null;
        this.$store.commit('setFilterBeginning', null);
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

      eventDateSplit: function() {
        return this.beginning.substr(0, this.eventBeginning.indexOf(" "));
      },

      eventTimeSplit: function() {
        return this.beginning.substr(this.eventBeginning.indexOf(" ") + 1);
      }
    },

    created() {
      window.setInterval(() => { this.checkScreenSize(); }, CHECK_INTERVAL);
      this.retrieveFilterOptions();

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

  .filter-button {
    width: 70px !important;
  }

  @media screen and (max-width: 836px) {
    .filter-button2 {
      width: 10px !important;
    }
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
