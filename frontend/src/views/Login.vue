<template>
  <div class="container">
    <div class="box">
      <div class="columns is-gapless">
        <!-- Login column -->
        <div class="column is-five">
          <form id="login" v-on:submit.prevent="checkLoginForm" method="post">
            <div class="columns">
              <div class="column">
                <h1 class="is-uppercase is-size-4">{{ $t("login") }}</h1>
              </div>
            </div>
            <div class="columns">
              <div class="column">
                <b-field
                  label="Email"
                  :type="{ 'is-danger': loginValidation.emailHasErrors }"
                >
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
                <b-field
                  v-bind:label="$t('password')"
                  :type="{ 'is-danger': loginValidation.passwordHasErrors }"
                >
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
              <div class="column level">
                <input
                  type="submit"
                  class="button is-success"
                  v-bind:value="$t('sign_in')"
                />
                <b-button type="is-text" @click="changePassword">
                  {{ $t("forgotten_password") }}
                </b-button>
              </div>
            </div>
          </form>
        </div>

        <!-- Divider column -->
        <div
          class="divider"
          v-bind:class="{ 'is-vertical': !isMobile, 'is-horizontal': isMobile }"
        >
          {{ $t("or") }}
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
                <h1 class="is-uppercase is-size-4">{{ $t("registration") }}</h1>
              </div>
            </div>
            <div class="columns">
              <div class="column">
                <b-field
                  v-bind:label="$t('name')"
                  :type="{ 'is-danger': registerValidation.nameHasErrors }"
                >
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
                <b-field
                  v-bind:label="$t('surname')"
                  :type="{ 'is-danger': registerValidation.surnameHasErrors }"
                >
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
                <b-field
                  label="Email"
                  :type="{ 'is-danger': registerValidation.emailHasErrors }"
                >
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
                <b-field
                  v-bind:label="$t('password')"
                  :type="{ 'is-danger': registerValidation.passwordHasErrors }"
                  :message="{
                    'Heslo musí obsahovať minimálne 6 znakov':
                      registerValidation.passwordHasErrors
                  }"
                >
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
                  v-bind:value="$t('register')"
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
import httpClient from "../httpClient";

export default {
  name: "login",
  data() {
    return {
      resetEmail: "",
      emailLogin: null,
      passwordLogin: null,
      emailRegistration: null,
      passwordRegistration: null,
      nameRegistration: null,
      surnameRegistration: null,
      loginValidation: {
        emailHasErrors: false,
        passwordHasErrors: false
      },
      registerValidation: {
        nameHasErrors: false,
        surnameHasErrors: false,
        emailHasErrors: false,
        passwordHasErrors: false
      }
    };
  },
  methods: {
    changePassword() {
      this.$buefy.dialog.prompt({
        message: this.$t("login_messages.enter_email"),
        inputAttrs: {
          maxlength: 255,
          type: "email"
        },
        confirmText: this.$t("send"),
        onConfirm: value => {
          httpClient
            .post("/users/password/create", { email: value })
            .then(() =>
              this.$buefy.toast.open({
                message: this.$t("login_messages.link_to_change_password"),
                type: "is-success"
              })
            )
            .catch(() =>
              this.$buefy.toast.open({
                message: this.$t("login_messages.error_occurred"),
                type: "is-danger"
              })
            );
        }
      });
    },
    checkLoginForm() {
      this.$store
        .dispatch("retrieveToken", {
          email: this.emailLogin,
          password: this.passwordLogin
        })
        .then(() => {
          this.$router.push({ name: "home" });
        })
        .catch(() => {
          this.loginValidation.emailHasErrors = true;
          this.loginValidation.passwordHasErrors = true;
          this.$buefy.toast.open({
            message: this.$t("login_messages.invalid_login_attempt"),
            type: "is-danger",
            duration: 3000
          });
        });
    },
    checkRegisterForm() {
      this.registerValidation = {
        nameHasErrors: false,
        surnameHasErrors: false,
        emailHasErrors: false,
        passwordHasErrors: false
      };
      if (this.nameRegistration === null || this.nameRegistration === "") {
        this.registerValidation.nameHasErrors = true;
      }
      if (
        this.surnameRegistration === null ||
        this.surnameRegistration === ""
      ) {
        this.registerValidation.surnameHasErrors = true;
      }
      if (!this.validEmail(this.emailRegistration)) {
        this.registerValidation.emailHasErrors = true;
      }
      if (
        this.passwordRegistration === null ||
        this.passwordRegistration.length < 7
      ) {
        this.registerValidation.passwordHasErrors = true;
      }
      if (
        !this.registerValidation.nameHasErrors &&
        !this.registerValidation.surnameHasErrors &&
        !this.registerValidation.emailHasErrors &&
        !this.registerValidation.passwordHasErrors
      ) {
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
                message: this.$t("login_messages.registered_successfully"),
                type: "is-success"
              });
            });
          })
          .catch(error => {
            console.log(error);
            if (error.data.errors.email) {
              this.$buefy.toast.open({
                message: this.$t("login_messages.email_exists"),
                type: "is-danger"
              });
              this.registerValidation.emailHasErrors = true;
            }
            if (error.data.errors.password) {
              this.$buefy.toast.open({
                message: this.$t("login_messages.invalid_password"),
                type: "is-danger"
              });
              this.registerValidation.passwordHasErrors = true;
            }
          });
      } else {
        this.$buefy.toast.open({
          message: this.$t("login_messages.registration_failed"),
          type: "is-danger"
        });
      }
    },
    validEmail: function(email) {
      var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
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
<style scoped>
.container {
  margin-top: 24px;
  padding: 0 0 !important;
}
.is-text {
  text-decoration: none;
  font-weight: 600;
  margin-left: 8px;
}
</style>
