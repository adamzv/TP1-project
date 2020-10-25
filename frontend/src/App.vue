<template>
  <div id="app">

    <b-navbar class="is-dark" :transparent="true">

      <template slot="brand">
        <b-navbar-item tag="router-link" :to="{ path: '/' }">
          <img
            src="../src/assets/logoukf.png"
            alt="Lightweight UI components for Vue.js based on Bulma"
          />
        </b-navbar-item>
      </template>

      <template slot="end">

        <b-navbar-item href="#">
          UKF.sk
        </b-navbar-item>

        <b-navbar-item href="#">
          {{ $t("ukf") }}
        </b-navbar-item>

        <b-navbar-dropdown
          class="locale-changer"
          :label="$t('language')"
          v-model="locale">

          <b-navbar-item
            v-for="(lang, i) in langs"
            :key="`Lang${i}`"
            :value="lang"
            @click="setLocale(lang)">
            {{ lang.toLocaleUpperCase() }}
          </b-navbar-item>
        </b-navbar-dropdown>

        <b-navbar-item tag="div">
          <div class="buttons">
            <a class="button is-light">
              {{ $t("login") }}
            </a>
          </div>
        </b-navbar-item>

      </template>

    </b-navbar>

    <b-carousel
      v-model="carousel"
      :animated="animated"
      :has-drag="drag"
      :autoplay="autoPlay"
      :pause-hover="pauseHover"
      :pause-info="pauseInfo"
      :pause-info-type="pauseType"
      :interval="interval"
      :repeat="repeat"
      @change="info($event)"
    >
      <b-carousel-item v-for="(carousel, i) in carousels" :key="i">
        <section :class="`hero is-medium is-${carousel.color} is-bold`">
          <!-- TODO: find images for background and specify correct size -->
          <img src="../src/assets/convention.jpg" width="auto" height="100%" />
          <div
            :class="
              `hero-body has-text-centered is-overlay ${carousel.overlay}`
            "
          >
            <h1 class="title">{{ carousel.title }}</h1>
            <h2>{{ carousel.time }}</h2>
          </div>
        </section>
      </b-carousel-item>
    </b-carousel>

    <!-- Container for scaling the page content -->
    <div class="container is-max-desktop">

      <!-- Actual reference of the EventComponent /w no props -->
      <EventComponent />
    </div>

    <router-view />
  </div>
</template>

<script>

  // Importing the EventComponent file
  import EventComponent from "./components/EventComponent";

  export default {
    components: {

      // Registering the EventComponent
      EventComponent
    },

    methods: {
      setLocale(lang) {
        this.$i18n.locale = lang;
      }
    },

    data() {
      return {
        langs: this.$i18n.availableLocales,
        locale: this.$i18n.locale,
        carousel: 0,
        pauseInfo: false,
        interval: 4000,
        carousels: [
          {
            title: "Univerzitná knižnica",
            color: "dark",
            overlay: "brown-overlay"
          },
          {
            title: "Fakulta sociálnych vied a zdravotníctva",
            color: "dark",
            overlay: "gray-overlay"
          },
          {
            title: "Pedagogická fakulta",
            color: "dark",
            overlay: "blue-overlay"
          },
          {
            title: "Fakulta prírodných vied",
            color: "dark",
            overlay: "green-overlay"
          },
          {
            title: "Fakulta stredoeurópskych štúdií",
            color: "dark",
            overlay: "orange-overlay"
          },
          {
            title: "Filozofická fakulta",
            color: "dark",
            overlay: "pink-overlay"
          }
        ]
      };
    }
  };
</script>

<style lang="scss">
  #app {
    font-family: "Avenir", Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
  }
  nav.navbar.is-dark {
    background: rgba(0, 0, 0, 0);
  }
  nav.navbar {
    position: absolute;
    width: 100%;
  }
  body {
    padding-top: 0px !important;
  }
  // TODO: Unify overlays according to faculty color schemes
  .blue-overlay {
    background: rgb(96, 212, 255);
    background: linear-gradient(
      90deg,
      rgba(96, 212, 255, 0.6) 0%,
      rgba(23, 144, 228, 0.6) 43%,
      rgba(0, 98, 167, 0.6) 75%,
      rgba(0, 78, 131, 0.6) 100%
    );
  }
  .green-overlay {
    background-image: linear-gradient(
      135deg,
      rgba(112, 245, 112, 0.4) 10%,
      rgba(73, 198, 40, 0.5) 100%
    );
  }
  .orange-overlay {
    background-image: linear-gradient(
      135deg,
      rgba(253, 216, 25, 0.5) 10%,
      rgba(232, 5, 5, 0.5) 100%
    );
  }
  .pink-overlay {
    background: rgb(244, 121, 188);
    background: linear-gradient(
      90deg,
      rgba(244, 121, 188, 0.5) 0%,
      rgba(212, 0, 117, 0.5) 73%,
      rgba(175, 0, 92, 0.5) 100%
    );
  }
  .brown-overlay {
    background: rgb(238, 109, 67);
    background: linear-gradient(
      43deg,
      rgba(238, 109, 67, 0.3) 0%,
      rgba(127, 24, 16, 0.6) 100%
    );
  }
  .gray-overlay {
    background: rgb(244, 244, 244);
    background: linear-gradient(
      90deg,
      rgba(244, 244, 244, 0.5) 0%,
      rgba(178, 178, 178, 0.5) 100%
    );
  }
</style>
