<template>
  <section>
    <div class="container">
      <form id="app" v-on:submit.prevent="checkForm" method="post">
        <b-collapse
          class="card"
          animation="slide"
          :open="isOpen == 0"
          @open="isOpen = 0"
        >
          <div
            slot="trigger"
            slot-scope="props"
            class="card-header"
            role="button"
          >
            <p class="card-header-title">
              Všeobecné nastavenia udalosti
            </p>
            <a class="card-header-icon">
              <b-icon :icon="props.open ? 'menu-down' : 'menu-up'"></b-icon>
            </a>
          </div>
          <div class="card-content">
            <div class="content">
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
                    @input="postPDF(file)"
                  >
                    <span>
                      <i class="mdi mdi-file-upload"></i>
                      Nahrať súbor .pdf
                    </span>
                  </b-upload>
                  <span v-if="file">
                    &nbsp;| {{ file.name.split("/")[2] }}.pdf
                    <b-button
                      v-if="fileUploadLoading"
                      :loading="fileUploadLoading"
                      size="is-small"
                    ></b-button>
                    <b-button
                      v-else
                      @click="removePDF"
                      type="is-danger"
                      size="is-small"
                      icon-right="delete"
                    ></b-button>
                  </span>
                </div>
              </div>
              <div class="columns">
                <div class="column">
                  <b-field label="Popis udalosti">
                    <b-input
                      maxlength="350"
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
                      v-model="placeName"
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
          </div>
        </b-collapse>
        <b-collapse
          class="card"
          animation="slide"
          :open="isOpen == 1"
          @open="isOpen = 1"
        >
          <div
            slot="trigger"
            slot-scope="props"
            class="card-header"
            role="button"
          >
            <p class="card-header-title">
              Univerzitné nastavenia
            </p>
            <a class="card-header-icon">
              <b-icon :icon="props.open ? 'menu-down' : 'menu-up'"></b-icon>
            </a>
          </div>
          <div class="card-content">
            <div class="content">
              <div class="columns">
                <div class="column">
                  <b-field label="Fakulta">
                    <b-autocomplete
                      v-model="selectedFacultyName"
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
                      v-model="selectedDepartmentName"
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
          </div>
        </b-collapse>
        <b-collapse
          class="card"
          animation="slide"
          :open="isOpen == 2"
          @open="isOpen = 2"
        >
          <div
            slot="trigger"
            slot-scope="props"
            class="card-header"
            role="button"
          >
            <p class="card-header-title">
              Galéria
            </p>
            <a class="card-header-icon">
              <b-icon :icon="props.open ? 'menu-down' : 'menu-up'"></b-icon>
            </a>
          </div>
          <div class="card-content">
            <div class="content">
              <div class="columns">
                <div class="column">
                  <div class="is-warning notification" v-if="!id">
                    Obrázky sa dajú vkladať až po skončení udalosti
                  </div>
                  <b-field>
                    <b-upload
                      v-model="pictures"
                      accept="image/*"
                      multiple
                      drag-drop
                      type="file"
                      :disabled="!id"
                      @input="uploadPictures()"
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
                      <Spinner
                        v-if="
                          !uploadingPicturesState.find(
                            state => state.name === file.name
                          )
                        "
                        size="tiny"
                        line-fg-color="#000"
                        style="margin-left: 4px; margin-right: -4px"
                      />
                      <button
                        v-else
                        class="delete is-small"
                        type="button"
                        @click="deletePicture(index, file.name)"
                      ></button>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </b-collapse>
        <div class="level">
          <div class="level-left"></div>
          <div class="level-right">
            <div class="level-item" v-if="!id">
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
import httpClient from "../../httpClient.js";
import moment from "moment";
import Spinner from "vue-simple-spinner";

export default {
  name: "manageEvent",
  components: {
    Spinner
  },
  props: {
    event: Object
  },
  data() {
    return {
      newCategoryName: "",
      availableCategories: [],
      filteredCategories: [],
      id: null,
      name: "",
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
      pictures: [],
      uploadingPicturesState: [],
      response: null,
      // collapse settings
      isOpen: 0,
      placeName: "",
      selectedDepartmentName: "",
      selectedFacultyName: "",
      fileLoading: false
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
      this.generateRequest();
    },
    postPDF(file) {
      this.$store.dispatch("updateLoading");
      var reader = new window.FileReader();
      reader.readAsDataURL(file);
      reader.onloadend = () => {
        var result = reader.result.split(",").pop();
        httpClient
          .post(`/files/pdf/${this.id}`, {
            pdf: result
          })
          .then(response => {
            console.log(response);
            this.$store.dispatch("updateLoading");
          })
          .catch(error => console.log(error));
      };
      reader.onerror = function(error) {
        console.log("Error: ", error);
      };
    },
    removePDF() {
      httpClient.delete(`/files/pdf/${this.id}`).then(() => {
        this.file = null;
      });
    },
    generateRequest() {
      if (this.id) {
        httpClient
          .put(`/events/${this.id}`, {
            name: this.name,
            desc: this.desc,
            room: this.room,
            categories: this.categories,
            id_place: this.place ? this.place.id : null,
            beginning: moment(this.beginning).format("YYYY-MM-DD HH:mm:ss"),
            end: null,
            // lecturer: this.lecturer,
            id_faculty: this.selectedFaculty ? this.selectedFaculty.id : null,
            id_department: this.selectedDepartment
              ? this.selectedDepartment.id
              : null,
            id_user: parseInt(this.$store.getters.loggedInId),
            // file: this.file,
            attendance_limit: this.attendanceLimit || -1
          })
          .then(() => {
            this.$store.commit("submitNewEvent", true);
            this.$buefy.toast.open({
              message: "Udalosť bola úspešne aktualizovaná!",
              type: "is-success"
            });
          })
          .catch(() => {
            this.$buefy.toast.open({
              message: "Udalosť sa nepodarilo aktualizovať!",
              type: "is-danger"
            });
          });
      } else {
        httpClient
          .post("/events", {
            name: this.name,
            desc: this.desc,
            room: this.room,
            categories: this.categories,
            id_place: this.place ? this.place.id : null,
            beginning: moment(this.beginning).format("YYYY-MM-DD HH:mm:ss"),
            end: null,
            // lecturer: this.lecturer,
            id_faculty: this.selectedFaculty ? this.selectedFaculty.id : null,
            id_department: this.selectedDepartment
              ? this.selectedDepartment.id
              : null,
            id_user: parseInt(this.$store.getters.loggedInId),
            // file: this.file,
            attendance_limit: this.attendanceLimit || -1
          })
          .then(() => {
            if (!this.createNext) {
              // clear form inputs
              this.clearFormInputs();
            }
            this.$store.commit("submitNewEvent", true);
            this.$buefy.toast.open({
              message: "Udalosť bola úspešne vytvorená!",
              type: "is-success"
            });
          })
          .catch(() => {
            this.$buefy.toast.open({
              message: "Udalosť sa nepodarilo vytvoriť!",
              type: "is-danger"
            });
          });
      }
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
    deletePicture(index, name) {
      this.pictures.splice(index, 1);
      const pathName = this.uploadingPicturesState.find(
        picture => picture.name === name
      );
      var path = pathName.path.split("/")[2];
      httpClient
        .delete(`/files/image/${this.id}/${path}`)
        .then(response => {
          console.log(response);
          this.uploadingPicturesState = this.uploadingPicturesState.filter(
            picture => picture.name !== name
          );
        })
        .catch(error => console.log(error));
    },
    uploadPictures() {
      console.log(this.pictures);
      for (const picture of this.pictures) {
        if (
          !this.uploadingPicturesState.find(state => state === picture.name)
        ) {
          var reader = new window.FileReader();
          reader.readAsDataURL(picture);
          reader.onloadend = () => {
            var result = reader.result.split(",").pop();
            httpClient
              .post(`/files/image/${this.id}`, {
                image: result
              })
              .then(response => {
                console.log(picture);
                console.log(response);
                this.uploadingPicturesState.push({
                  name: picture.name,
                  path: response.data.path
                });
              })
              .catch(error => {
                console.log(error);
              });
          };
        }
      }
    },
    clearFormInputs() {
      this.name = "";
      this.desc = null;
      this.id = null;
      this.categories = [];
      this.beginning = null;
      this.place = null;
      this.selectedDepartment = "";
      this.selectedFaculty = "";
      this.room = null;
      this.lecturer = null;
      this.file = null;
      this.isAttendanceLimit = false;
      this.attendanceLimit = null;
      this.pictures = [];
      // string properties for some inputs
      this.placeName = "";
      this.selectedDepartmentName = "";
      this.selectedFacultyName = "";
    },
    editFormInputs() {
      this.name = this.getEvent.name;
      this.desc = this.getEvent.desc;
      this.id = this.getEvent.id;
      this.categories = this.getEvent.categories;
      this.beginning = moment(
        this.getEvent.beginning,
        "YYYY-MM-DD HH:mm:ss"
      ).toDate();
      this.place = this.getEvent.place;
      this.selectedDepartment = this.getEvent.department;
      this.selectedFaculty = this.getEvent.faculty;
      this.room = this.getEvent.room;
      this.lecturer = this.getEvent.lecturer;
      this.file = this.getEvent.file;
      this.isAttendanceLimit = this.getEvent.attendanceLimit > -1;
      this.attendanceLimit =
        this.getEvent.attendanceLimit > -1
          ? this.getEvent.attendanceLimit
          : null;
      this.pictures = this.getEvent.pictures;
      // string properties for some inputs
      this.placeName = this.place.name;
      this.selectedDepartmentName = this.selectedDepartment
        ? this.selectedDepartment.name
        : "";
      this.selectedFacultyName = this.selectedFaculty.name;
    }
  },
  watch: {
    getEvent(val) {
      if (val) {
        this.editFormInputs();
      } else {
        this.clearFormInputs();
      }
    },
    id(val) {
      if (val) {
        this.$store.commit("pushToLoading", "EventPDF");
        httpClient
          .get(`/files/pdf/${this.id}`)
          .then(response => {
            this.file = {};
            this.file.name = response.data.pdfs_path.pdf1_path;
            this.$store.commit("finishLoading", "EventPDF");
          })
          .catch(() => {
            this.$store.commit("finishLoading", "EventPDF");
          });
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
    getEvent() {
      return this.event;
    },
    fileUploadLoading() {
      return this.$store.getters.fileUploadLoading;
    }
  },
  created() {
    this.$store.commit("pushToLoading", "ManageEventCategories");
    httpClient.get("/categories").then(response => {
      this.availableCategories = response.data;
      this.filteredCategories = response.data;
      this.$store.commit("finishLoading", "ManageEventCategories");
    });

    this.$store.commit("pushToLoading", "ManageEventPlaces");
    httpClient.get("/places").then(response => {
      this.availablePlaces = response.data;
      this.$store.commit("finishLoading", "ManageEventPlaces");
    });

    this.$store.commit("pushToLoading", "ManageEventDepartments");
    httpClient.get("/departments").then(response => {
      this.availableDepartments = response.data;
      this.$store.commit("finishLoading", "ManageEventDepartments");
    });

    this.$store.commit("pushToLoading", "ManageEventFaculties");
    httpClient.get("/faculties").then(response => {
      this.availableFaculties = response.data;
      this.$store.commit("finishLoading", "ManageEventFaculties");
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
