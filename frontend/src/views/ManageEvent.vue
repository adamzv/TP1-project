<template>
  <section>
    <div class="container">
      <h1 class="is-uppercase is-size-4">Vytvorenie novej udalosti</h1>
      <hr class="hr" />

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
                :open-on-focus="false"
                icon="label"
                placeholder="Pridať kategóriu"
                @typing="getFilteredTags"
              ></b-taginput>
            </b-field>
            <a @click="isCategoryModalActive = true">Pridať novú kategóriu</a>
            <b-modal
              v-model="isCategoryModalActive"
              has-modal-card
              trap-focus
              :destroy-on-hide="false"
              aria-role="dialog"
              aria-modal
            >
              <template #default="props">
                <div class="card">
                  <div class="card-content">
                    <div class="content">
                      <b-field label="Name">
                        <b-input v-model="newCategoryName"></b-input>
                      </b-field>
                      <button
                        class="button is-primary is-medium"
                        @click="addNewCategory"
                      >
                        Launch image modal
                      </button>
                    </div>
                  </div>
                </div>
              </template>
            </b-modal>
          </div>
          <div class="column"></div>
          <div class="column"></div>
        </div>
        <div class="columns">
          <div class="column">
            <b-field label="Popis udalosti">
              <b-input maxlength="500" v-model="desc" type="textarea"></b-input>
            </b-field>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import httpClient from "../httpClient.js";

export default {
  name: "manageEvent",
  created() {
    // loads categories from backend
    httpClient.get("/categories").then(response => {
      this.availableCategories = response.data;
    });
  },
  data() {
    return {
      newCategoryName: "",
      isCategoryModalActive: false,
      availableCategories: [],
      filteredCategories: [],
      id: null,
      name: "Kariérne dni",
      desc: null,
      categories: []
    };
  },
  methods: {
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
    addNewCategory() {
      this.availableCategories.push({ name: this.newCategoryName });
      this.newCategoryName = "";
      // TODO add validation
      // TODO make modal prettier
      this.isCategoryModalActive = false;
    }
  }
};
</script>

<style>
.columns.notification {
  padding-top: 12px;
}
</style>
