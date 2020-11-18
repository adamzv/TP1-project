<template>
  <div class="container is-fluid filterPanel">

    <!-- This was the only way I could make it work, too much time spent, had to compromise for sanity reasons. -->
    <!-- Filter view for mobile screen sizes  -->
    <div v-if="showMobile == true && showDesktop == false">
      <b-collapse
              aria-id="contentIdForA11y2"
              class="panel collapse"
              animation="slide"
              v-model="isOpen"
              :open="isOpen = false">
        <div
                slot="trigger"
                class="panel-heading filterHeading"
                role="button"
                v-if="windowWidth <= 768"
                aria-controls="contentIdForA11y2">

          <b-icon icon="filter" style="" size="is-large" v-if="windowWidth <= 768"></b-icon>
        </div>

        <div class="panel-block filterBlock">
          <div class="columns columnsPos">
            <div class="column filterItem">
              <b-datetimepicker
                      v-model="beginning"
                      icon="calendar-today"
                      :locale="'sk-SK'"
                      ref="datepicker"
                      placeholder="Dátum konania"
                      horizontal-time-picker>

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
                      @typing="getFilteredTags">

              </b-taginput>
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
                      :clearable="true">
              </b-autocomplete>
            </div>

            <div class="column filterItem">
              <b-autocomplete
                      v-model="selectedDepartmentName"
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
              <b-autocomplete
                      v-model="placeName"
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

        <div style="padding-right: 35px;" v-if="windowWidth <= 768">
          <div class="level-right filterButton" style=" padding-bottom: 2px; padding-left: 12px;">
            <b-button class="level-item" icon-left="filter" style="width: 100%;">Filtrovať</b-button>
          </div>
        </div>
      </b-collapse>
    </div>

    <!-- Filter view for desktop and tablet screen sizes  -->
    <div v-else-if="showMobile == false && showDesktop == true">
      <b-collapse
              aria-id="contentIdForA11y2"
              class="panel collapse"
              animation="slide"
              v-model="isOpen"
              :open="isOpen = true">

        <div class="panel-block filterBlock">
          <b-icon icon="filter" style="position: absolute; margin-left: 60px;" size="is-large" v-if="windowWidth > 1840">
          </b-icon>

          <div class="columns columnsPos">
            <div class="column filterItem">
              <b-datetimepicker
                      v-model="beginning"
                      icon="calendar-today"
                      :locale="'sk-SK'"
                      ref="datepicker"
                      placeholder="Dátum konania"
                      horizontal-time-picker>

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
                      @typing="getFilteredTags">
              </b-taginput>
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
                      :clearable="true">
              </b-autocomplete>
            </div>

            <div class="column filterItem">
              <b-autocomplete
                      v-model="selectedDepartmentName"
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
              <b-autocomplete
                      v-model="placeName"
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

            <div class="column" style="text-align: right;" v-if="windowWidth <= 1840 && windowWidth > 768">
              <b-button class="" icon-left="filter" style="width: auto !important;">Filtrovať</b-button>
            </div>

            <div>
              <div class="level-right filterButton" align="right" style="position: absolute; right: 35px;">
                <b-button class="level-item" icon-left="filter" style="" v-if="windowWidth > 1840">Filtrovať</b-button>
              </div>
            </div>
          </div>
        </div>
      </b-collapse>
    </div>
  </div>
</template>

<script>
  const MOBILE_SIZE = 768;
  const CHECK_INTERVAL = 50;

  export default {
    data() {
      return {
        isOpen: true,
        windowWidth: window.innerWidth,
        showDesktop: true,
        showMobile: false
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
      }
    },

    created() {
      window.setInterval(() => { this.checkScreenSize(); }, CHECK_INTERVAL);
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
    text-align: center;
  }

  .filterPanel {
    width: 100%;
    border-radius: 10px;
  }

  .columnsPos {
    width: 1560px; margin: 0 auto !important;
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
