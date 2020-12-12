<template>
  <section>
    <b-field grouped group-multiline>
      <b-select v-model="perPage" :disabled="!isPaginated">
        <option value="5">5 na stranu</option>
        <option value="10">10 na stranu</option>
        <option value="15">15 na stranu</option>
        <option value="20">20 na stranu</option>
      </b-select>
      <div class="control is-flex">
        <b-switch v-model="isPaginated">Stránkovanie</b-switch>
      </div>
      <div class="control is-flex">
        <b-switch v-model="nameSearchable">Vyhľadať</b-switch>
      </div>
    </b-field>

    <b-table
      :data="data"
      :paginated="isPaginated"
      :per-page="perPage"
      :current-page.sync="currentPage"
      :default-sort-direction="defaultSortDirection"
      :pagination-rounded="isPaginationRounded"
      :sort-icon="sortIcon"
      :sort-icon-size="sortIconSize"
      default-sort="user.first_name"
      aria-next-label="Next page"
      aria-previous-label="Previous page"
      aria-page-label="Page"
      aria-current-label="Current page"
    >
      <b-table-column
        field="id"
        label="ID"
        width="40"
        sortable
        numeric
        v-slot="props"
      >
        {{ props.row.id }}
      </b-table-column>

      <b-table-column
        field="name"
        label="Názov"
        :searchable="nameSearchable"
        sortable
        v-slot="props"
      >
        {{ props.row.name }}
      </b-table-column>
      <b-table-column custom-key="actions" label="Actions" v-slot="props">
        
        <button
          v-if="props.row.id_role != 1"
          class="button is-small is-danger"
          @click="deleteCategory(props.row.id)"
        >
          <b-icon icon="delete" size="is-small"></b-icon>
        </button>
      </b-table-column>
    </b-table>
  </section>
</template>

<script>
import httpClient from "../httpClient.js";

export default {
  props: {
    category: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      data: this.category,
      isPaginated: true,
      nameSearchable: false,
      paginationPosition: "bottom",
      defaultSortDirection: "asc",
      sortIcon: "arrow-up",
      sortIconSize: "is-small",
      currentPage: 1,
      perPage: 5
    };
  },
  watch: {
    category() {
      if (this.category.length > 0) {
        this.data = this.category;
      }
    }
  },
  methods: {
    deleteCategory(id) {
      httpClient
        .delete(`/categories/${id}`)
        .then(() => {
            this.data = this.data.filter(data => data.id != id);
          this.$buefy.toast.open({
            message: "Kategória bola vymazaná!",
            type: "is-success"
          });
        })
        .catch(error => {
          console.log(error);
          this.$buefy.toast.open({
            message: "Kategóriu sa nepodarilo vymazať!",
            type: "is-danger"
          });
        });
    },
    
  }
};
</script>
