<template>
  <form
    class="container is-fluid filterPanel"
    v-on:keydown.enter="sendDataToParent"
  >
    <!-- Filter view for mobile screen sizes  -->
    <div v-if="showMobile && !showDesktop && render">
      <b-collapse
        aria-id="contentIdForA11y2"
        class="panel collapse"
        animation="fade"
        v-model="isOpen"
        :open="(isOpen = false)"
      >
        <div
          slot="trigger"
          class="panel-heading filterHeading"
          role="button"
          v-if="windowWidth <= 768"
          aria-controls="contentIdForA11y2"
        >
          <div @click="addOpenIndex()" class="mobile-filter-trigger">
            <div style="padding-left: 35px;" v-if="windowWidth <= 768">
              <b-icon icon="filter" size="is-medium"></b-icon>

              <h1 class="mobile-filter-trigger-icon">
                <b-icon
                  icon="chevron-down"
                  size="is-medium"
                  v-if="openIndex % 2 == 0"
                ></b-icon>
                <b-icon icon="chevron-up" size="is-medium" v-else></b-icon>
              </h1>
            </div>
          </div>
        </div>

        <div class="panel-block filterBlock">
          <div class="columns columnsPos">
            <div class="column filterItem">
              <b-input
                v-model="eventName"
                field="name"
                placeholder="Názov"
              ></b-input>
            </div>

            <div class="column filterItem">
              <b-datetimepicker
                v-model="beginning"
                icon="calendar-today"
                :locale="'sk-SK'"
                ref="datepicker"
                placeholder="Dátum konania"
                horizontal-time-picker
              >
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
            </div>

            <div class="column">
              <b-button
                style="color: white; width: 100%;"
                class="button"
                type="is-danger"
                icon-left="delete-outline"
                @click="clearDateFilter"
              >
                Vymazať dátum
              </b-button>
            </div>

            <div class="column filterItem">
              <b-taginput
                v-model="categories"
                :data="filteredCategories"
                field="name"
                autocomplete
                :allow-new="false"
                :open-on-focus="true"
                :keep-first="true"
                icon="label"
                placeholder="Kategórie"
                @typing="getFilteredTags"
              ></b-taginput>
            </div>

            <div class="column filterItem">
              <b-autocomplete
                v-model="selectedFacultyName"
                :keep-first="true"
                :open-on-focus="true"
                placeholder="Fakulta"
                :data="availableFaculties"
                field="name"
                @select="option => (selectedFaculty = option)"
                v-on:select="checkIfDepartmentIsSelected"
                :clearable="true"
              ></b-autocomplete>
            </div>

            <div class="column filterItem">
              <b-autocomplete
                v-model="selectedDepartmentName"
                :keep-first="true"
                :open-on-focus="true"
                :data="getFilteredDepartments"
                field="name"
                placeholder="Katedra"
                :clearable="true"
              ></b-autocomplete>
            </div>

            <div class="column filterItem">
              <b-autocomplete
                v-model="placeName"
                ref="autocomplete"
                :data="availablePlaces"
                field="name"
                :keep-first="true"
                :open-on-focus="true"
                :clearable="true"
                placeholder="Miesto konania"
                @select="option => (place = option)"
              ></b-autocomplete>
            </div>
          </div>
        </div>

        <div style="padding-right: 35px;" v-if="windowWidth <= 768">
          <div
            class="level-right filterButton"
            style=" padding-bottom: 2px; padding-left: 12px;"
          >
            <b-button
              class="level-item is-danger"
              icon-left="delete-outline"
              style="width: 100%;"
              @click="clearFilter()"
            >
              Vymazať filter
            </b-button>

            <b-button
              class="level-item is-info"
              icon-left="filter"
              style="width: 100%;"
              @click="sendDataToParent()"
            >
              Filtrovať
            </b-button>
          </div>
        </div>
      </b-collapse>
    </div>

    <!-- Filter view for desktop and tablet screen sizes  -->
    <div v-else-if="!showMobile && showDesktop && render">
      <b-collapse
        aria-id="contentIdForA11y2"
        class="panel collapse"
        animation="slide"
        v-model="isOpen"
        :open="(isOpen = true)"
      >
        <div class="panel-block filterBlock">
          <b-icon
            icon="filter"
            class="desktop-filter-icon"
            size="is-large"
            v-if="windowWidth > 1895"
          ></b-icon>

          <div class="columns columnsPos">
            <div class="column filterItem">
              <b-input
                v-model="eventName"
                field="name"
                v-bind:placeholder="$t('filter.title')"
              ></b-input>
            </div>

            <div class="column filterItem">
              <b-datetimepicker
                v-model="beginning"
                icon="calendar-today"
                :locale="'sk-SK'"
                ref="datepicker"
                v-bind:placeholder="$t('filter.from_date')"
                horizontal-time-picker
              >
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
            </div>

            <b-button
              outlined
              class="button btn-desktop-remove-date filter-button3"
              type="button"
              icon-left="delete-outline"
              @click="clearDateFilter"
            ></b-button>

            <div class="column filterItem">
              <b-taginput
                v-model="categories"
                :data="filteredCategories"
                field="name"
                autocomplete
                :allow-new="false"
                :open-on-focus="true"
                :keep-first="true"
                icon="label"
                v-bind:placeholder="$t('filter.categories')"
                @typing="getFilteredTags"
              ></b-taginput>
            </div>

            <div class="column filterItem">
              <b-autocomplete
                v-model="selectedFacultyName"
                :keep-first="true"
                :open-on-focus="true"
                v-bind:placeholder="$t('filter.faculty')"
                :data="availableFaculties"
                field="name"
                @select="option => (selectedFaculty = option)"
                v-on:select="checkIfDepartmentIsSelected"
                :clearable="true"
              ></b-autocomplete>
            </div>

            <div class="column filterItem">
              <b-autocomplete
                v-model="selectedDepartmentName"
                :keep-first="true"
                :open-on-focus="true"
                :data="getFilteredDepartments"
                field="name"
                v-bind:placeholder="$t('filter.department')"
                :clearable="true"
              ></b-autocomplete>
            </div>

            <div class="column filterItem">
              <b-autocomplete
                v-model="placeName"
                ref="autocomplete"
                :data="availablePlaces"
                field="name"
                :keep-first="true"
                :open-on-focus="true"
                :clearable="true"
                v-bind:placeholder="$t('filter.venue')"
                @select="option => (place = option)"
              ></b-autocomplete>
            </div>

            <div
              class="column"
              style="text-align: right;"
              v-if="windowWidth <= 1895 && windowWidth > 768"
            >
              <b-button
                class="is-danger filter-button2 eliminate-right-radius"
                icon-left="delete-outline"
                @click="clearFilter()"
              ></b-button>

              <b-button
                class="is-info filter-button2 eliminate-left-radius"
                icon-left="filter"
                @click="sendDataToParent()"
              ></b-button>
            </div>

            <div>
              <div
                class="level-right filterButton"
                align="right"
                style="position: absolute; right: 12px;"
              >
                <b-button
                  class="level-item is-danger filter-button eliminate-right-radius"
                  icon-left="delete-outline"
                  @click="clearFilter()"
                  v-if="windowWidth > 1895"
                ></b-button>

                <b-button
                  class="level-item is-info filter-button eliminate-left-radius"
                  icon-left="filter"
                  @click="sendDataToParent()"
                  v-if="windowWidth > 1895"
                ></b-button>
              </div>
            </div>
          </div>
        </div>
      </b-collapse>
    </div>
  </form>
</template>

<script>
import httpClient from "../httpClient";
import moment from "moment";

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
      pageUrls: [],
      index: 0,
      apiRequest: `/events`,
      render: true
    };
  },

  methods: {
    checkScreenSize() {
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
      this.$store.commit("setPageIndex", 0);
      this.createFilterRequest();
      this.loadEvents(this.$store.getters.getCurrentApiUrl);
    },

    async clearFilter() {
      this.$store.commit("setPageIndex", 0);
      this.$store.commit("setPageIndex", this.$store.getters.getPageIndex + 1);
      this.$store.commit("clearPageArray", []);

      this.$store.commit("pushToLoading", "FilterComponent");
      httpClient.get(`/events?page=1`).then(response_x => {
        if (response_x.data.data != "") {
          this.$store.commit("addPageToArray", response_x.data.data);
          this.$store.commit("setNextPage", response_x.data.next_page_url);
          this.$store.commit("setCurrentApiUrl", `/events`);
        }

        this.$store.commit("finishLoading", "FilterComponent");
      });

      this.setFilterOptionsClear();
      this.setFilterOptions();
    },

    async getRequestFilteredEvents(apiUrl) {
      this.$store.commit("clearPageArray", []);
      this.$store.commit("setURL_API_FILTER", apiUrl);
    },

    loadEvents(url) {
      this.$store.commit("setPageIndex", this.$store.getters.getPageIndex + 1);
      this.$store.commit("pushToLoading", "FilterComponent");
      this.$store.commit("setCanLoadEvents", false);

      if (url != `/events`) {
        httpClient
          .get(url + `&page=${this.$store.getters.getPageIndex}`)
          .then(response_x => {
            if (response_x.data.data != "") {
              this.$store.commit("addPageToArray", response_x.data.data);
              this.$store.commit("setNextPage", response_x.data.next_page_url);
            }
            this.$store.commit("finishLoading", "FilterComponent");
            this.$store.commit("setCanLoadEvents", true);
          });
      } else if (url == `/events?page=1`) {
        httpClient
          .get(`/events?page=${this.$store.getters.getPageIndex + 1}`)
          .then(response_x => {
            if (response_x.data.data != "") {
              this.$store.commit("addPageToArray", response_x.data.data);
              this.$store.commit("setNextPage", response_x.data.next_page_url);
            }
            this.$store.commit("finishLoading", "FilterComponent");
            this.$store.commit("setCanLoadEvents", true);
          });
      } else {
        httpClient
          .get(url + `?page=${this.$store.getters.getPageIndex}`)
          .then(response_x => {
            if (response_x.data.data != "") {
              this.$store.commit("addPageToArray", response_x.data.data);
              this.$store.commit("setNextPage", response_x.data.next_page_url);
            }
            this.$store.commit("finishLoading", "FilterComponent");
            this.$store.commit("setCanLoadEvents", true);
          });
      }
    },

    generateCorrectDatetime() {
      let dateRaw = String(this.beginning);
      let year = dateRaw.substr(11, dateRaw.indexOf(" ") + 1);
      let month = this.getCorrectMonthFormat(
        dateRaw.substr(4, dateRaw.indexOf(" "))
      );
      let day = dateRaw.substr(8, dateRaw.indexOf(" ") - 1);
      let time = dateRaw.substr(16, 8);
      let date = year + "-" + month + "-" + day;

      let finalDate = date + " " + time;

      if (
        finalDate == "te() { [n-- Date() { [nativ" ||
        finalDate == "-- " ||
        finalDate == ""
      )
        return "";
      else return finalDate;
    },

    nameFilterRequestPart(insertFilter) {
      if (insertFilter) {
        return `name=${this.eventName}`;
      } else {
        return `name=${this.eventName}`;
      }
    },

    dateFilterRequestPart(
      insertFilter,
      date,
      doFilterName,
      dofilterFaculty,
      doFilterDepartment
    ) {
      if (
        (insertFilter && !doFilterName) ||
        (insertFilter && !dofilterFaculty) ||
        (insertFilter && !doFilterDepartment)
      ) {
        return `,beginning=${date}`;
      } else return `,beginning=2000-01-01 00:00:00`;
    },

    facultyFilterRequestPart(insertFilter) {
      if (insertFilter) {
        return `,id_faculty=${this.selectedFaculty.id}`;
      } else return ``;
    },

    departmentFilterRequestPart(insertFilter, department_id) {
      if (insertFilter) {
        return `,id_department=${department_id}`;
      } else return ``;
    },

    placeFilterRequestPart(insertFilter, place_id) {
      if (insertFilter) {
        return `,id_place=${place_id}`;
      } else return ``;
    },

    categoriesFilterRequestPart(insertFilter, cat_array) {
      if (insertFilter) {
        let api_string = "";

        for (let i = 0; i < cat_array.length; i++) {
          if (i == 0) {
            api_string += String(cat_array[i]);
          } else {
            api_string += "!" + String(cat_array[i]);
          }
        }

        return `,categories_id=${api_string}`;
      } else {
        return ``;
      }
    },

    getIdOfFilteredPlace(filteredPlaceName) {
      let allPlaces = this.availablePlaces;
      let filteredPlaceNameSearchReady = String(
        filteredPlaceName
      ).toLowerCase();

      if (filteredPlaceNameSearchReady != "") {
        for (let i = 0; i < allPlaces.length; i++) {
          let actualPlace = allPlaces[i];
          let actualPlaceName = String(actualPlace.name).toLowerCase();

          if (actualPlaceName.includes(filteredPlaceNameSearchReady)) {
            return actualPlace.id;
          } else {
            continue;
          }
        }
      }
    },

    getIdOfFilteredCategory(filteredCategoriesArray) {
      let allCategories = this.availableCategories;
      let filteredCategoriesNames = [];

      for (let x = 0; x < filteredCategoriesArray.length; x++) {
        if (filteredCategoriesArray[x] != null) {
          filteredCategoriesNames.push(
            String(filteredCategoriesArray[x].name).toLowerCase()
          );
        }
      }

      let filteredCategoriesIds = [];

      for (let y = 0; y < allCategories.length; y++) {
        let actualCategory = allCategories[y];
        let actualCategoryName = String(actualCategory.name).toLowerCase();

        for (let z = 0; z < filteredCategoriesNames.length; z++) {
          if (actualCategoryName.includes(filteredCategoriesNames[z])) {
            filteredCategoriesIds.push(actualCategory.id);
          }
        }
      }

      return filteredCategoriesIds;
    },

    buildRequest() {
      let apiDate = this.generateCorrectDatetime();
      let apiDept = this.getDepId(this.selectedDepartmentName);

      let isName = this.eventName != "";
      let isDate = apiDate != "";
      let isFaculty = this.selectedFaculty != null;
      let isDepartment = apiDept != "";
      let isPlace = this.placeName != "";
      let isCategories = this.categories.length > 0;

      let arrayOfData = [false, false, false, false, false, false];

      if (isName) {
        arrayOfData[0] = true;
      } else {
        arrayOfData[0] = false;
      }
      if (isDate) {
        arrayOfData[1] = true;
      } else {
        arrayOfData[1] = false;
      }
      if (isFaculty) {
        arrayOfData[2] = true;
      } else {
        arrayOfData[2] = false;
      }
      if (isDepartment) {
        arrayOfData[3] = true;
      } else {
        arrayOfData[3] = false;
      }
      if (isPlace) {
        arrayOfData[4] = true;
      } else {
        arrayOfData[4] = false;
      }
      if (isCategories) {
        arrayOfData[5] = true;
      } else {
        arrayOfData[5] = false;
      }

      let doFilterName = arrayOfData[0];
      let doFilterDate = arrayOfData[1];
      let doFilterFaculty = arrayOfData[2];
      let doFilterDepartment = arrayOfData[3];
      let doFilterPlace = arrayOfData[4];
      let doFilterCategories = arrayOfData[5];

      let request = "";

      if (
        !isName &&
        !isFaculty &&
        !isDepartment &&
        !isDate &&
        !isPlace &&
        !isCategories
      ) {
        request = `/events`;
        this.apiRequest = request;
        this.$store.commit("setCurrentApiUrl", request);
      } else {
        request = `/events?filter=${this.nameFilterRequestPart(
          doFilterName
        )}${this.dateFilterRequestPart(
          doFilterDate,
          apiDate,
          doFilterName
        )}${this.facultyFilterRequestPart(
          doFilterFaculty
        )}${this.departmentFilterRequestPart(
          doFilterDepartment,
          apiDept
        )}${this.placeFilterRequestPart(
          doFilterPlace,
          this.getIdOfFilteredPlace(this.placeName)
        )}${this.categoriesFilterRequestPart(
          doFilterCategories,
          this.getIdOfFilteredCategory(this.categories)
        )}`;

        this.apiRequest = request;
        this.$store.commit("setCurrentApiUrl", request);
      }

      //execute filtering
      this.getRequestFilteredEvents(request);
    },

    createFilterRequest() {
      this.setFilterOptions();
      this.buildRequest();
    },

    getCorrectMonthFormat(dateRaw) {
      return moment()
        .month(dateRaw)
        .format("MM");
    },

    getDepId(depRaw) {
      var department = this.availableDepartments.find(
        dep => dep.name === depRaw
      );
      return department ? department.id : null;
    },

    retrieveFilterOptions() {
      this.eventName = this.$store.getters.getFilterEventName;
      this.beginning = this.$store.getters.getFilterBeginning;
      this.categories = this.$store.getters.getFilterCategories;
      this.selectedFacultyName = this.$store.getters.getFilterFaculty;
      this.selectedDepartmentName = this.$store.getters.getFilterDepartment;
      this.placeName = this.$store.getters.getFilterPlace;
    },

    setFilterOptions() {
      this.$store.commit("setFilterEventName", this.eventName);
      this.$store.commit("setFilterBeginning", this.beginning);
      this.$store.commit("setFilterFaculty", this.selectedFacultyName);
      this.$store.commit("setFilterDepartment", this.selectedDepartmentName);
      this.$store.commit("setFilterPlace", this.placeName);
      this.$store.commit("setFilterCategories", this.categories);
    },

    setFilterOptionsClear() {
      this.eventName = "";
      this.beginning = null;
      this.categories = "";
      this.selectedFacultyName = "";
      this.selectedDepartmentName = "";
      this.placeName = "";
      this.render = false;
      this.$nextTick(() => {
        this.render = true;
      });
    },

    clearDateFilter() {
      this.beginning = null;
      this.$store.commit("setFilterBeginning", null);
      this.render = false;
      this.$nextTick(() => {
        this.render = true;
      });
    }
  },

  computed: {
    getCurrentApiUrl() {
      return this.$store.getters.getCurrentApiUrl;
    },

    getFilteredDepartments() {
      if (this.selectedFaculty != null) {
        return this.availableDepartments.filter(department => {
          return (
            this.selectedFaculty !== null &&
            department.id_faculty === this.selectedFaculty.id
          );
        });
      } else {
        return this.availableDepartments;
      }
    },

    eventDateSplit: function() {
      return this.beginning.substr(0, this.eventBeginning.indexOf(" "));
    },

    eventTimeSplit: function() {
      return this.beginning.substr(this.eventBeginning.indexOf(" ") + 1);
    }
  },

  created() {
    window.setInterval(() => {
      this.checkScreenSize();
    }, CHECK_INTERVAL);
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

    if (this.$store.getters.getFirstTimeLoaded == false) {
      this.loadEvents(this.getCurrentApiUrl);
      this.$store.commit("setFirstTimeLoaded", true);
    }
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
  background: rgb(219, 219, 219);
  background: linear-gradient(
    0deg,
    rgba(219, 219, 219, 1) 0%,
    rgba(241, 241, 241, 1) 100%
  );
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
  width: 1560px;
  margin: 0 auto !important;
}

.btn-desktop-remove-date {
  margin-top: 12px;
  margin-left: -82px;
  height: 40px;
  border-top-left-radius: 0px !important;
  border-bottom-left-radius: 0px !important;
  color: #737373;
  width: 70px;
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

.filter-button3 {
  width: 70px !important;
}

.eliminate-right-radius {
  margin-right: 0px !important;
  border-top-right-radius: 0px !important;
  border-bottom-right-radius: 0px !important;
}

.eliminate-left-radius {
  margin-left: 0px !important;
  border-top-left-radius: 0px !important;
  border-bottom-left-radius: 0px !important;
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

@media screen and (max-width: 1895px) {
  .filter-button3 {
    width: 40px !important;
    margin-left: -15px !important;
  }
}

@media screen and (max-width: 768px) {
  .filterButton {
    width: 100%;
  }
}
</style>
