<template>
  <div id="app">
    <b-navbar class="is-link" :fixed-top="false" :transparent="true">
      <template slot="brand">
        <b-navbar-item tag="router-link" :to="{ path: '/' }">
          <img
            src="../src/assets/logoukf.png"
            alt="Lightweight UI components for Vue.js based on Bulma"
          />
        </b-navbar-item>
      </template>
      <template slot="start">
        <b-navbar-item href="#">
          Home
        </b-navbar-item>
        <b-navbar-item href="#">
          Documentation
        </b-navbar-item>
      </template>

      <template slot="end">
        <b-navbar-item tag="div">
          <div class="buttons">
            <a class="button is-success">
              <strong>Sign up</strong>
            </a>
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
          <div class="hero-body has-text-centered">
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
      interval: 3000,
      carousels: [
        { title: "Lorem Ipsum Event 1", color: "dark" },
        { title: "Lorem Ipsum Event 2", color: "primary" },
        { title: "Lorem Ipsum Event 3", color: "info" },
        { title: "Lorem Ipsum Event 4", color: "success" },
        { title: "Lorem Ipsum Event 5", color: "warning" },
        { title: "Lorem Ipsum Event 6", color: "danger" }
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
#nav {
  padding: 30px;
  a {
    font-weight: bold;
    color: #2c3e50;
    &.router-link-exact-active {
      color: #42b983;
    }
  }
  // position: absolute;
  // background: rgb(0, 0, 0);
  // opacity: 0.85;
}
nav.navbar.is-fixed-top {
  background: transparent;
}
nav.navbar.is-link {
  background: rgba(0, 0, 0, 0);
  position: absolute;
}
body {
  padding-top: 0px !important;
}
</style>
