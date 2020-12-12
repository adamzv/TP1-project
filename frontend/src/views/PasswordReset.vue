<template>
  <div style="margin-top: 24px;" class="container">
    <div class="columns">
      <div class="column is-half is-offset-one-quarter">
        <form id="login" v-on:submit.prevent="checkResetForm" method="post">
          <div class="page-margin">
            <h1 class="is-uppercase is-size-4">
              Zmena hesla
            </h1>
            <hr class="hr" />
            <div class="box">
              <div class="columns">
                <div class="column">
                  <b-field
                    label="Nové heslo"
                    :message="{
                      'Heslo musí mať viac ako 6 znakov': passwordHasErrors
                    }"
                    :type="{ 'is-danger': passwordHasErrors }"
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
                <div class="column">
                  <b-field
                    label="Zopakujte nové heslo"
                    :type="{ 'is-danger': passwordHasErrors }"
                  >
                    <b-input
                      name="passwordRetype"
                      id="passwordLoginRetype"
                      type="password"
                      v-model="passwordLoginRetype"
                    ></b-input>
                  </b-field>
                </div>
              </div>
              <div class="columns">
                <div class="column">
                  <input
                    type="submit"
                    class="button is-success"
                    value="Zmeniť heslo"
                  />
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import httpClient from "../httpClient";

export default {
  name: "passwordReset",
  data() {
    return {
      passwordLogin: "",
      passwordLoginRetype: "",
      passwordHasErrors: false
    };
  },
  methods: {
    checkResetForm() {
      if (
        this.passwordLogin !== this.passwordLoginRetype ||
        this.passwordLogin.length < 7
      ) {
        this.passwordHasErrors = true;
      } else {
        this.passwordHasErrors = false;
      }

      if (!this.passwordHasErrors) {
        httpClient
          .post("/users/password/reset", {
            password: this.passwordLogin,
            password_confirmation: this.passwordLoginRetype,
            token: this.$route.params.token
          })
          .then(() =>
            this.$router.push("/login", () => {
              this.$buefy.toast.open({
                message: "Heslo bolo zmenené",
                type: "is-success",
                duration: 3000
              });
            })
          )
          .catch();
      }
    }
  }
};
</script>

<style></style>
