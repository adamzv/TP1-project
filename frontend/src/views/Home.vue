<template>
  <div class="home">
    <FilterComponent id="myFilter" class="filter" @clicked="onClickChild" />
    <EventListComponent />
  </div>
</template>

<script>
  import EventListComponent from "../components/event/EventListComponent";
  import FilterComponent from "@/components/FilterComponent.vue";

  export default {
    name: "home",
    components: { EventListComponent, FilterComponent },

    created()   { window.addEventListener('scroll', this.myFunction); },
    destroyed() { window.removeEventListener('scroll', this.myFunction); },

    methods: {
      myFunction () {
        var filter = document.getElementById("myFilter");
        var sticky = filter.offsetTop;

        // TODO: Second value is not correct nor exact, needs to be somehow modified for carouselHeight from VUEX
        if (window.pageYOffset * 4 > sticky) { filter.classList.add("sticky"); }
        if (window.pageYOffset < 350) { filter.classList.remove("sticky"); }
      },

      onClickChild(value) {
        this.events = value.filteredEvents;
      }
    },

    data() {
      return {
        events: [],
        isOpen: true,
        windowWidth: window.innerWidth,
        showDesktop: true,
        showMobile: false,
        openIndex: 0,
      };
    },
  };
</script>

<style lang="scss" scoped>
  .home {
    text-align: center;
  }

  .filter {
    z-index: 1000;
    -webkit-box-shadow: 0px 18px 42px -17px rgba(0, 0, 0, 0.5);
    -moz-box-shadow: 0px 18px 42px -17px rgba(0, 0, 0, 0.5);
    box-shadow: 0px 18px 42px -17px rgba(0, 0, 0, 0.5);
    margin-bottom: -20px;
  }

  .sticky {
    position: fixed;
    top: 0px;
    left: 50%;
    transform: translateX(-50%);
  }
</style>