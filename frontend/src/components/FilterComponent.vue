<template>
  <div class="container is-fluid filterPanel">

    <b-collapse
      aria-id="contentIdForA11y2"
      class="panel"
      animation="slide"
      v-model="isOpen">
      <div
        slot="trigger"
        class="panel-heading filterHeading"
        role="button"
        aria-controls="contentIdForA11y2">

        <strong>Filter </strong>
        <b-icon icon="filter"></b-icon>
      </div>

      <div class="panel-block filterBlock" style="padding-bottom: 30px;">
        <div class="columns" style="width: 100%;">
          <div class="column filterItem">
            <b-field label="Dátum konania">
              <b-datetimepicker
                      v-model="beginning"
                      placeholder="Vybrať dátum a čas"
                      icon="calendar-today"
                      :locale="'sk-SK'"
                      ref="datepicker"
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
            </b-field>
          </div>

          <div class="column filterItem">
            <b-field label="Kategórie">
              <b-taginput
                      v-model="categories"
                      :data="filteredCategories"
                      field="name"
                      autocomplete
                      :allow-new="false"
                      :open-on-focus="true"
                      :keep-first="true"
                      icon="label"
                      placeholder="Pridať kategóriu"
                      @typing="getFilteredTags">

              </b-taginput>
            </b-field>
          </div>

          <div class="column filterItem">
            <b-field label="Katedra">
              <b-autocomplete
                      v-model="selectedDepartmentName"
                      :keep-first="true"
                      :open-on-focus="true"
                      :data="getFilteredDepartments"
                      field="name"
                      :disabled="selectedFaculty == null"
                      :clearable="true">
              </b-autocomplete>
            </b-field>
          </div>

          <div class="column filterItem">
            <b-field label="Fakulta">
              <b-autocomplete
                      v-model="selectedFacultyName"
                      :keep-first="true"
                      :open-on-focus="true"
                      :data="availableFaculties"
                      field="name"
                      @select="option => (selectedFaculty = option)"
                      v-on:select="checkIfDepartmentIsSelected"
                      :clearable="true">
              </b-autocomplete>
            </b-field>
          </div>

          <div class="column filterItem">
            <b-field label="Miesto konania">
              <b-autocomplete
                      v-model="placeName"
                      ref="autocomplete"
                      :data="availablePlaces"
                      field="name"
                      :keep-first="true"
                      :open-on-focus="true"
                      :clearable="true"
                      placeholder="Vybrať miesto konania udalosti"
                      @select="option => (place = option)">

                <template slot="header">
                  <a @click="console.log('todo')">
                    <span>Pridať nové miesto</span>
                  </a>
                </template>
              </b-autocomplete>
            </b-field>
          </div>
        </div>
      </div>

      <div class="level is-mobile filterBottomPart">
        <div class="level-left"></div>
        <div class="level-right filterButton">
          <b-button class="level-item is-primary" outlined style="margin-right: 35px; margin-left: 30px;">Filtrovať</b-button>
        </div>
      </div>
    </b-collapse>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isOpen: true
    };
  }
};
</script>

<style>
.container {
  margin-top: 24px;
  padding: 0 0 !important;
  text-align: left;
}
.level-item {
  margin: 12px 12px;
}

  .filterItem {
    margin-left: 20px;
  }

  .filterHeading {
    text-align: left;
  }

  .filterBlock {
    background: white;
  }

  .filterPanel {
    width: 1536px !important;
    border-radius: 10px;
  }

  .filterBottomPart {
    background: white;
    border-bottom-right-radius: 10px;
    border-bottom-left-radius: 10px;
  }

@media screen and (max-width: 1075px) {
  .filterHeading {
    text-align: center;
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
