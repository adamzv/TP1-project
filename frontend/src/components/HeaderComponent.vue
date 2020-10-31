<template>
  <div>
    <b-navbar class="is-dark" :transparent="true">
      <template slot="brand">
        <b-navbar-item tag="router-link" :to="{ path: '/' }">
          <img src="../assets/logoukf.png" alt="UKF Logo" />
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
      :has-drag="true"
      :pause-info="false"
      :interval="4000"
      :repeat="true"
    >
      <b-carousel-item v-for="(carousel, i) in carousels" :key="i">
        <section :class="`hero is-medium is-${carousel.color} is-bold`">
          <!-- TODO: find images for background and specify correct size -->
          <img :src="getImgUrl(i)" width="auto" height="100%" />
          <div
            :class="
              `hero-body has-text-centered is-overlay ${carousel.overlay}`
            "
          >
            <h1 class="title">{{ carousel.title }}</h1>
            <h1 class="subtitle">{{ formatRemainingTime(carousel.time) }}</h1>
          </div>
        </section>
      </b-carousel-item>
    </b-carousel>
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
      return `https://picsum.photos/id/43${value}/1230/350`;
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
    }
  },
  data() {
    return {
      counter: 0,
      langs: this.$i18n.availableLocales,
      locale: this.$i18n.locale,
      carousel: 0,
      // hardcoded 'events' to test carousel features
      carousels: [
        {
          title: "Univerzitná knižnica",
          time: 1603806300000,
          color: "dark",
          overlay: "brown-overlay"
        },
        {
          title: "Fakulta sociálnych vied a zdravotníctva",
          time: 1603806300000,
          color: "dark",
          overlay: "gray-overlay"
        },
        {
          title: "Pedagogická fakulta",
          time: 1603806300000,
          color: "dark",
          overlay: "blue-overlay"
        },
        {
          title: "Fakulta prírodných vied",
          time: 1603806300000,
          color: "dark",
          overlay: "green-overlay"
        },
        {
          title: "Fakulta stredoeurópskych štúdií",
          time: 1603806300000,
          color: "dark",
          overlay: "orange-overlay"
        },
        {
          title: "Filozofická fakulta",
          time: 1603806300000,
          color: "dark",
          overlay: "pink-overlay"
        }
      ]
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
</style>