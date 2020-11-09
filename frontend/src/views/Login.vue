<template>
  <div class="container">
    <div class="box">
      <div class="columns is-gapless">
        <!-- Login column -->
        <div class="column is-five">
          <form id="login" v-on:submit.prevent="checkLoginForm" method="post">
            <div class="columns">
              <div class="column">
                <h1 class="is-uppercase is-size-4">Prihlásiť sa</h1>
              </div>
            </div>
            <div class="columns">
              <div class="column">
                <b-field label="Email">
                  <b-input
                    name="email"
                    id="emailLogin"
                    type="email"
                    v-model="emailLogin"
                  ></b-input>
                </b-field>
              </div>
            </div>
            <div class="columns">
              <div class="column">
                <b-field label="Heslo">
                  <b-input
                    name="password"
                    id="passwordLogin"
                    type="password"
                    v-model="passwordLogin"
                  ></b-input>
                </b-field>
              </div>
            </div>
            <div class="columns">
              <div class="column">
                <input
                  type="submit"
                  class="button is-success"
                  value="Prihlásenie"
                />
              </div>
            </div>
          </form>
        </div>

        <!-- Divider column -->
        <div
          class="divider"
          v-bind:class="{ 'is-vertical': !isMobile, 'is-horizontal': isMobile }"
        >
          Alebo
        </div>

        <!-- Register column -->
        <div class="column is-five">
          <form
            id="register"
            v-on:submit.prevent="checkRegisterForm"
            method="post"
          >
            <div class="columns">
              <div class="column">
                <h1 class="is-uppercase is-size-4">Registrácia</h1>
              </div>
            </div>
            <div class="columns">
              <div class="column">
                <b-field label="Meno">
                  <b-input
                    name="name"
                    id="nameRegistration"
                    v-model="nameRegistration"
                  ></b-input>
                </b-field>
              </div>
            </div>
            <div class="columns">
              <div class="column">
                <b-field label="Priezvisko">
                  <b-input
                    name="surname"
                    id="surnameRegistration"
                    v-model="surnameRegistration"
                  ></b-input>
                </b-field>
              </div>
            </div>
            <div class="columns">
              <div class="column">
                <b-field label="Email">
                  <b-input
                    name="email"
                    id="emailRegistration"
                    type="email"
                    v-model="emailRegistration"
                  ></b-input>
                </b-field>
              </div>
            </div>
            <div class="columns">
              <div class="column">
                <b-field label="Heslo">
                  <b-input
                    name="password"
                    id="passwordRegistration"
                    type="password"
                    v-model="passwordRegistration"
                  ></b-input>
                </b-field>
              </div>
            </div>
            <div class="columns">
              <div class="column">
                <input
                  type="submit"
                  class="button is-success"
                  value="Odoslať"
                />
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "login",
  data() {
    return {
      emailLogin: null,
      passwordLogin: null,
      emailRegistration: null,
      passwordRegistration: null,
      nameRegistration: null,
      surnameRegistration: null
    };
  },
  methods: {
    checkLoginForm() {
      this.$store
        .dispatch("retrieveToken", {
          email: this.emailLogin,
          password: this.passwordLogin
        })
        .then(() => {
          this.$router.push({ name: "home" });
        });
    },
    checkRegisterForm() {
      this.$store
        .dispatch("register", {
          name: this.nameRegistration,
          surname: this.surnameRegistration,
          email: this.emailRegistration,
          password: this.passwordRegistration
        })
        .then(() => {
          this.$router.push({ name: "home" }, () => {
            this.$buefy.toast.open({
              message: "Boli ste úspešne zaregistrovaná/ý!",
              type: "is-success"
            });
          });
        })
        .catch(() => {
          this.$buefy.toast.open({
            message: "Registrácia bola neúspešná!",
            type: "is-danger"
          });
        });
    }
  },
  computed: {
    isMobile() {
      const isMobile = window.matchMedia("only screen and (max-width: 768px)");
      return isMobile.matches ? true : false;
    }
  }
};
</script>

<style lang="sass">
// these two imports are required for bulma-divider to work
@import "~bulma/bulma.sass";
@import "~buefy/src/scss/buefy";
@import "~@creativebulma/bulma-divider";
</style>
