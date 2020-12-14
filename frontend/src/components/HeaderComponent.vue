<template>
  <div>
    <b-navbar class="is-dark" :transparent="true" style="z-index: 1001;">
      <template slot="brand">
        <b-navbar-item tag="router-link" :to="{ path: '/' }">
          <img src="../assets/logoukf.png" alt="UKF Logo" />
        </b-navbar-item>
      </template>
      <template slot="end">
        <b-navbar-item tag="router-link" to="/">
          {{ $t("home") }}
        </b-navbar-item>
        <b-navbar-item href="https://www.ukf.sk">
          UKF.sk
        </b-navbar-item>
        <b-navbar-item href="https://www.ukf.sk/mojaukf">
          {{ $t("ukf") }}
        </b-navbar-item>
        <b-navbar-dropdown
          :collapsible="true"
          :label="$t('language')"
          v-model="locale"
        >
          <b-navbar-item
            v-for="(lang, i) in langs"
            :key="`Lang${i}`"
            :value="lang"
            @click="setLocale(lang)"
          >
            {{ lang.toLocaleUpperCase() }}
          </b-navbar-item>
        </b-navbar-dropdown>
        <b-navbar-item v-if="!loggedIn">
          <b-button tag="router-link" to="/login" type="is-light">
            {{ $t("sign_in") }}
          </b-button>
        </b-navbar-item>
        <b-navbar-dropdown
          :right="true"
          v-if="loggedIn"
          :collapsible="true"
          :label="loggedInName"
        >
          <b-navbar-item tag="router-link" to="/profile">
            {{ $t("profile") }}
          </b-navbar-item>
          <b-navbar-item @click="logout">
            {{ $t("logout") }}
          </b-navbar-item>
        </b-navbar-dropdown>
      </template>
    </b-navbar>
    <div v-if="events.length > 0" style="width:100%">
      <b-carousel
        v-model="carousel"
        :has-drag="true"
        :pause-info="false"
        :interval="4000"
        :repeat="true"
      >
        <b-carousel-item v-for="(event, i) in events" :key="i">
          <section class="hero is-medium is-bold is-dark">
            <!-- TODO: find images for background and specify correct size -->
            <img
              class="imgSettings"
              :alt="event.name"
              v-if="event.titleImg[0]"
              :src="getImgUrl(event.titleImg[0])"
            />
            <img
              v-else
              class="imgSettings"
              src="https://picsum.photos/id/2/1230/500"
              :alt="event.name"
            />
            <div
              class="hero-body has-text-centered is-overlay"
              v-bind:class="{
                'green-overlay': event.faculty.id == 1,
                'gray-overlay': event.faculty.id == 2,
                'orange-overlay': event.faculty.id == 3,
                'pink-overlay': event.faculty.id == 4,
                'blue-overlay': event.faculty.id == 5,
                'ukf-overlay': event.faculty.id == 6,
                'brown-overlay': event.faculty.id == 7
              }"
            >
              <h1 class="title">
                <a class="title" :href="`/event/${event.id}`">
                  {{ event.name }}
                </a>
              </h1>
              <h1 class="subtitle">
                {{ formatRemainingTime(event.beginning) }}
              </h1>
            </div>
          </section>
        </b-carousel-item>
      </b-carousel>
    </div>
  </div>
</template>

<script>
import moment from "moment";
import countdown from "countdown";
import { ONE, FEW, MANY } from "../const.js";

export default {
  created: function() {
    // every second an anonymous function will be called which causes re-render of the countdown string
    this.advance();
    this.countdownTranslate();
  },

  methods: {
    setLocale(lang) {
      this.$i18n.locale = lang;

      this.countdownTranslate();
    },
    // sample function which returns "lorem ipsum" image for carousel background
    // in the future every background image needs to have at least 350px height
    getImgUrl(value) {
      return process.env.VUE_APP_IMAGES_STORAGE_URL + value;
    },
    advance: function() {
      setTimeout(() => {
        this.counter++;
        this.advance();
      }, 1000);
    },
    formatRemainingTime(endTime) {
      // this counter causes refresh
      this.counter + 1;
      return moment(endTime)
        .countdown()
        .toString();
    },
    // formatter used to correctly translate time units in carousel
    slovakCountdownUnitsFormatter: function(value, unit) {
      if (value === 1) {
        // singular
        return value + ONE[unit];
      }
      if (value >= 2 && value <= 4) {
        return value + FEW[unit];
      }
      // general plural
      return value + MANY[unit];
    },
    // translates countdown in carousel according to selected language
    countdownTranslate: function() {
      if (this.$i18n.locale.toLowerCase() === "sk") {
        countdown.setFormat({
          last: " a ",
          formatter: this.slovakCountdownUnitsFormatter
        });
      } else {
        countdown.resetFormat();
      }
    },
    logout() {
      this.$store.dispatch("destroyToken").then(() => {
        this.$router.push({ name: "home" });
      });
    }
  },
  computed: {
    loggedIn() {
      return this.$store.getters.loggedIn;
    },
    loggedInName() {
      return this.$store.getters.loggedInName;
    },
    addEventPermission() {
      return this.$store.getters.permissionToAddEvents;
    }
  },
  props: {
    events: Array
  },
  data() {
    return {
      counter: 0,
      langs: this.$i18n.availableLocales,
      locale: this.$i18n.locale,
      carousel: 0
    };
  }
};
</script>

<style scoped lang="scss">
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
.carousel {
  overflow: hidden;
}
.carousel.carousel-items {
  height: 100%;
}

.imgSettings {
  filter: grayscale(100%);
  max-height: 350px;
  width: 100%;
  object-fit: cover;
}

@media screen and (max-width: 768px) {
  .carousel {
    margin-bottom: 0px;
  }
  .imgSettings {
    max-height: 500px;
  }
  h1.title {
    font-size: 1.25rem;
  }
  a.title {
    font-size: 1.25rem;
  }
  h1.subtitle {
    font-size: 1rem;
  }
}
</style>
