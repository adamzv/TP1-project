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
      default-sort="notify"
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
        v-bind:label="$t('name')"
        :searchable="nameSearchable"
        sortable
        v-slot="props"
      >
        {{ props.row.name }}
      </b-table-column>

      <b-table-column
        field="surname"
        v-bind:label="$t('surname')"
        :searchable="nameSearchable"
        sortable
        v-slot="props"
      >
        {{ props.row.surname }}
      </b-table-column>
      <b-table-column
        field="email"
        label="Email"
        :searchable="nameSearchable"
        sortable
        v-slot="props"
      >
        {{ props.row.email }}
      </b-table-column>
      <b-table-column field="id_role" label="Práva" sortable v-slot="props">
        <label v-if="props.row.id_role === 1">Admin</label>
        <label v-if="props.row.id_role === 2">Moderátor</label>
        <label v-if="props.row.id_role === 3">Používateľ</label>
      </b-table-column>
      <b-table-column custom-key="actions" label="Actions" v-slot="props">
        <b-tooltip label="Povýšiť" type="is-dark">
          <button
            v-if="props.row.id_role === 3"
            class="button is-small is-light"
            @click="upgrade(props.row.id)"
          >
            <b-icon icon="arrow-up" size="is-small"></b-icon>
          </button>
        </b-tooltip>
        <b-tooltip label="Degradovať" type="is-dark">
          <button
            v-if="props.row.id_role === 2"
            class="button is-small is-light"
            @click="downgrade(props.row.id)"
          >
            <b-icon icon="arrow-down" size="is-small"></b-icon>
          </button>
        </b-tooltip>
        <button
          v-if="props.row.id_role != 1"
          class="button is-small is-danger"
          @click="deleteUser(props.row.id)"
        >
          <b-icon icon="delete" size="is-small"></b-icon>
        </button>
      </b-table-column>
      <b-table-column
        field="notify"
        label="Notifikácia"
        sortable
        v-slot="props"
      >
        <b-tooltip label="Používateľ žiada zmenu práv" type="is-dark">
          <button
            v-if="props.row.notify === 1"
            class="button is-small is-light"
            @click="deleteNotify(props.row.id)"
          >
            <b-icon icon="bell-ring" size="is-small"></b-icon>
          </button>
        </b-tooltip>
      </b-table-column>
    </b-table>
  </section>
</template>

<script>
import httpClient from "../httpClient.js";

export default {
  props: {
    users: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      data: this.users,
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
    users() {
      if (this.users.length > 0) {
        this.data = this.users;
      }
    }
  },
  methods: {
    deleteNotify(id) {
      httpClient
        .post(`/users/notify/${id}`, { notify: null })
        .then(() => {
          this.$buefy.toast.open({
            message: "Notifikácia bola odstránená!",
            type: "is-success"
          });
        })
        .catch(error => {
          console.log(error);
          this.$buefy.toast.open({
            message: "Notifikáciu sa nepodarilo odstrániť!",
            type: "is-danger"
          });
        });
    },
    deleteUser(id) {
      httpClient
        .delete(`/users/${id}`)
        .then(() => {
          this.data = this.data.filter(data => data.id != id);
          this.$buefy.toast.open({
            message: "Používatel bol vymazaný!",
            type: "is-success"
          });
        })
        .catch(error => {
          console.log(error);
          this.$buefy.toast.open({
            message: "Používatela sa nepodarilo vymazať!",
            type: "is-danger"
          });
        });
    },
    upgrade(id) {
      httpClient
        .put(`/users/updateUsersRole/${id}`, {
          id_role: 2,
          notify: null
        })
        .then(() => {
          this.$buefy.toast.open({
            message: "Oprávnenie bolo zmenené!",
            type: "is-success"
          });
        })
        .catch(error => {
          console.log(error);
          this.$buefy.toast.open({
            message: "Nepodarilo sa zmeniť oprávnenia!",
            type: "is-danger"
          });
        });
    },
    downgrade(id) {
      httpClient
        .put(`/users/updateUsersRole/${id}`, {
          id_role: 3,
          notify: null
        })
        .then(() => {
          this.$buefy.toast.open({
            message: "Oprávnenie bolo zmenené!",
            type: "is-success"
          });
        })
        .catch(error => {
          console.log(error);
          this.$buefy.toast.open({
            message: "Nepodarilo sa zmeniť oprávnenia!",
            type: "is-danger"
          });
        });
    }
  }
};
</script>
