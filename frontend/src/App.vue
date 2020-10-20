<template>
  <div id="app">
    <b-navbar class="is-dark" :fixed-top="false" :transparent="true">
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
          Moja UKF
        </b-navbar-item>
        <b-navbar-item tag="div">
          <div class="buttons">
            <a class="button is-light">
              Log in
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
    <router-view />
  </div>
</template>

<script>
export default {
  data() {
    return {
      carousel: 0,
      pauseInfo: false,
      interval: 4000,
      carousels: [
        {
          title: "Lorem Ipsum Event 1",
          color: "dark",
          overlay: "angled-overlay"
        },
        {
          title: "Lorem Ipsum Event 2",
          color: "dark",
          overlay: "yellow-overlay"
        },
        {
          title: "Lorem Ipsum Event 3",
          color: "dark",
          overlay: "color-overlay"
        },
        {
          title: "Lorem Ipsum Event 4",
          color: "dark",
          overlay: "color-overlay"
        },
        {
          title: "Lorem Ipsum Event 5",
          color: "dark",
          overlay: "color-overlay"
        },
        {
          title: "Lorem Ipsum Event 6",
          color: "dark",
          overlay: "color-overlay"
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
.color-overlay {
  background: rgb(131, 58, 180);
  background: linear-gradient(
    90deg,
    rgba(131, 58, 180, 0.5) 0%,
    rgba(253, 29, 29, 0.5) 50%,
    rgba(252, 176, 69, 0.5) 100%
  );
}
.angled-overlay {
  background: #4158d0;
  background: linear-gradient(
    43deg,
    rgba(65, 88, 208, 0.5) 0%,
    rgba(200, 80, 192, 0.5) 46%,
    rgba(255, 204, 112, 0.5) 100%
  );
}
.yellow-overlay {
  background: linear-gradient(
    90deg,
    rgba(248, 255, 0, 0.5) 0%,
    rgba(58, 213, 159, 0.5) 100%
  );
}
</style>
