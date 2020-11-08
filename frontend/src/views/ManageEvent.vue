<template>
  <section>
    <div class="container">
      <!-- Nova udalost -->
      <h1 class="is-uppercase is-size-4">Vytvorenie novej udalosti</h1>
      <hr class="hr" />
      <form id="app" v-on:submit.prevent="checkForm" method="post">
        <div class="box">
          <div class="columns">
            <div class="column is-two-fifths">
              <b-field label="Názov udalosti">
                <b-input v-model="name"></b-input>
              </b-field>
            </div>
            <div class="column">
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
                  @typing="getFilteredTags"
                >
                  <template slot="header">
                    <a @click="addNewCategory">
                      <span>Nová kategória</span>
                    </a>
                  </template>
                </b-taginput>
              </b-field>
            </div>
            <div class="column">
              <b-field label="Dátum konania">
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
          </div>
          <div class="columns">
            <div class="column">
              <!-- TODO toto je odkaz na modal okno nie b-upload -->
              <b-upload v-model="file" class="file-label has-text-link">
                <span>
                  <i class="mdi mdi-upload"></i>
                  Nahrať (zvoliť) titulnú fotku
                </span>
              </b-upload>
              <br />
              <b-upload
                v-model="file"
                type="file"
                accept=".pdf"
                class="file-label has-text-link"
              >
                <span>
                  <i class="mdi mdi-file-upload"></i>
                  Nahrať súbor .pdf
                </span>
              </b-upload>
              <span v-if="file">
                &nbsp;| {{ file.name }}
                <a @click="file = null">
                  <i class="mdi mdi-close-thick has-text-danger"></i>
                </a>
              </span>
            </div>
          </div>
          <div class="columns">
            <div class="column">
              <b-field label="Popis udalosti">
                <b-input
                  maxlength="500"
                  v-model="desc"
                  type="textarea"
                ></b-input>
              </b-field>
            </div>
          </div>
          <div class="columns">
            <div class="column">
              <b-field label="Miesto konania">
                <b-autocomplete
                  ref="autocomplete"
                  :data="availablePlaces"
                  field="name"
                  :keep-first="true"
                  :open-on-focus="true"
                  :clearable="true"
                  placeholder="Vybrať miesto konania udalosti"
                  @select="option => (place = option)"
                >
                  <template slot="header">
                    <a @click="console.log('todo')">
                      <span>Pridať nové miesto</span>
                    </a>
                  </template>
                </b-autocomplete>
              </b-field>
            </div>
            <div class="column">
              <b-field label="Miestnosť">
                <b-input v-model="room"></b-input>
              </b-field>
            </div>
            <div class="column"></div>
          </div>
        </div>
        <!-- Univerzitne nastavenia -->
        <h1 class="is-uppercase is-size-4">Univerzitné nastavenia</h1>
        <hr class="hr" />
        <div class="box">
          <div class="columns">
            <div class="column">
              <b-field label="Fakulta">
                <b-autocomplete
                  :keep-first="true"
                  :open-on-focus="true"
                  :data="availableFaculties"
                  field="name"
                  @select="option => (selectedFaculty = option)"
                  v-on:select="checkIfDepartmentIsSelected"
                  :clearable="true"
                ></b-autocomplete>
              </b-field>
            </div>
            <div class="column">
              <b-field label="Katedra">
                <b-autocomplete
                  v-model="selectedDepartment"
                  :keep-first="true"
                  :open-on-focus="true"
                  :data="getFilteredDepartments"
                  field="name"
                  :disabled="selectedFaculty == null"
                  :clearable="true"
                ></b-autocomplete>
              </b-field>
            </div>
            <div class="column">
              <b-field label="Prednášajúci">
                <b-input v-model="lecturer"></b-input>
              </b-field>
            </div>
          </div>
          <div class="columns">
            <div class="column ">
              <b-field grouped label="Obmedziť počeť miest?">
                <b-checkbox v-model="isAttendanceLimit"></b-checkbox>
                <b-input
                  type="number"
                  :disabled="!isAttendanceLimit"
                  v-model="attendanceLimit"
                ></b-input>
              </b-field>
            </div>
          </div>
        </div>
        <!-- Galeria -->
        <!-- TODO: zobrazit galeriu len pri editovani? -->
        <!-- TODO: kazdy obrazok sa hned v @input evente nahra na server,
             server vrati url + id + nazov, co sa vykresli na stranke 
             (potom pouzivatel moze vymazat obrazok -> hned sa vymaze na serveri) -->
        <h1 class="is-uppercase is-size-4">Galéria</h1>
        <hr class="hr" />
        <div class="box">
          <div class="columns">
            <div class="column">
              <b-field>
                <b-upload
                  v-model="pictures"
                  accept="image/*"
                  multiple
                  drag-drop
                  type="file"
                >
                  <section class="section">
                    <div class="content has-text-centered">
                      <p>
                        <b-icon icon="upload" size="is-large"></b-icon>
                      </p>
                      <p>Drop your files here or click to upload</p>
                    </div>
                  </section>
                </b-upload>
              </b-field>

              <div class="tags">
                <span
                  v-for="(file, index) in pictures"
                  :key="index"
                  class="tag is-info"
                >
                  {{ file.name }}
                  <button
                    class="delete is-small"
                    type="button"
                    @click="deletePicture(index)"
                  ></button>
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="level">
          <div class="level-left">
            <div class="level-item">
              <b-button
                type="button"
                class="is-danger"
                tag="router-link"
                to="/"
              >
                Zrušiť
              </b-button>
            </div>
          </div>
          <div class="level-right">
            <div class="level-item">
              <b-checkbox v-model="createNext" type="is-info">
                Vytvoriť ďalší
              </b-checkbox>
            </div>
            <div class="level-item">
              <input
                type="submit"
                class="button is-success"
                value="Vytvoriť udalosť"
              />
            </div>
          </div>
        </div>
      </form>
    </div>
  </section>
</template>

<script>
import httpClient from "../httpClient.js";

export default {
  name: "manageEvent",
  data() {
    return {
      newCategoryName: "",
      availableCategories: [],
      filteredCategories: [],
      id: null,
      name: "Kariérne dni",
      desc: null,
      categories: [],
      beginning: null,
      place: null,
      availablePlaces: [],
      createNext: false,
      selectedDepartment: null,
      selectedFaculty: null,
      availableDepartments: [],
      availableFaculties: [],
      room: null,
      lecturer: null,
      file: null,
      isAttendanceLimit: false,
      attendanceLimit: null,
      pictures: []
    };
  },
  methods: {
    addNewCategory() {
      this.$buefy.dialog.prompt({
        message: `Pridať novú kategóriu`,
        inputAttrs: {
          maxlength: 255,
          value: this.newCategoryName
        },
        confirmText: "Add",
        onConfirm: value => {
          this.availableCategories.push({ name: value });
          this.categories.push({ name: value });
          this.newCategoryName = "";
        }
      });
    },
    checkForm() {
      // TODO add axios post
      if (this.createNext) {
        // this console.log simulates POST request
        console.log(this.generateJSON());
        this.$buefy.toast.open({
          message: "Udalosť bola úspešne vytvorená!",
          type: "is-success"
        });
      } else {
        // this console.log simulates POST request
        console.log(this.generateJSON());
        this.$router.push({ name: "home" }, () => {
          this.$buefy.toast.open({
            message: "Udalosť bola úspešne vytvorená!",
            type: "is-success"
          });
        });
      }
    },
    generateJSON() {
      return JSON.stringify({
        name: this.name,
        desc: this.desc,
        categories: this.categories,
        place: this.place,
        beginning: this.beginning,
        lecturer: this.lecturer,
        faculty: this.selectedFaculty,
        department: this.selectedDepartment,
        room: this.room,
        user: "TODO",
        file: this.file,
        attendanceLimit: this.attendanceLimit
      });
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
        console.log("true");
      }
    },
    deletePicture(index) {
      this.pictures.splice(index, 1);
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
    }
  },
  created() {
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
.columns.notification {
  padding-top: 12px;
}
/* Set top margin to 0 so that timepicker 
 and button are vertically centered */
.datepicker-footer .level .level-item {
  margin: 0px 12px;
}
</style>
