<template>
  <div class="home">
    <FilterComponent id="myFilter" class="filter" ref="filter" />
    <EventListComponent v-bind:page-id="increasePageId(page)"
                        v-for="page in this.$store.getters.getPages.length"
                        v-bind:key="page.id"
                        :events="loadedEvents"/>
  </div>
</template>

<script>
import EventListComponent from "../components/event/EventListComponent";
import FilterComponent from "../components/FilterComponent";

export default {
  name: "home",
  components: { EventListComponent, FilterComponent },
  created() {
    window.addEventListener("scroll", this.myFunction);
  },
  destroyed() {
    window.removeEventListener("scroll", this.myFunction);
  },

  mounted() {
    this.scrolledToBottom();
  },

  props: {
    loadedEvents: Array
  },
  
  methods: {
    myFunction() {
      var filter = document.getElementById("myFilter");
      var sticky = filter.offsetTop;

      if (window.pageYOffset * 4 > sticky) {
        filter.classList.add("sticky");
      }
      if (window.pageYOffset < 350) {
        filter.classList.remove("sticky");
      }
    },

    increasePageId(index) {
      return index + 1;
    },

    scrolledToBottom () {
      window.onscroll = async () => {
        if (this.getCanLoadEvents) {
          let bottomOfWindow = Math.max(window.pageYOffset, document.documentElement.scrollTop, document.body.scrollTop) + window.innerHeight === document.documentElement.offsetHeight;

          if (bottomOfWindow) {
            this.isAtBottom = true;

            if (this.$store.getters.getNextPage != null) {
              this.$refs.filter.loadEvents(this.getCurrentApiUrl);
            }
          } else {
              this.isAtBottom = false;
          }
        }
      }
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
      pageUrls: [],
      pageId: 5,
      isAtBottom: false
    };
  },

  filters: {
    reverse(items) {
      return items.slice().reverse();
    }
  },

  computed: {
    getCurrentApiUrl() {
      return this.$store.getters.getCurrentApiUrl;
    },
    getCanLoadEvents() {
        return this.$store.getters.getCanLoadEvents;
    }
  }
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
