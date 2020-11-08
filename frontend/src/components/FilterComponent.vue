<template>
  <div class="container is-fluid">
    <b-collapse
      aria-id="contentIdForA11y2"
      class="panel"
      animation="slide"
      v-model="isOpen"
    >
      <div
        slot="trigger"
        class="panel-heading"
        role="button"
        aria-controls="contentIdForA11y2"
      >
        <strong>Filter</strong>
      </div>
      <div class="panel-block">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
        <br />
        Nulla accumsan, metus ultrices eleifend gravida, nulla nunc varius
        lectus, nec rutrum justo nibh eu lectus.
        <br />
        Ut vulputate semper dui. Fusce erat odio, sollicitudin vel erat vel,
        interdum mattis neque.
      </div>
      <div class="level is-mobile">
        <div class="level-left"></div>
        <div class="level-right">
          <b-button class="is-success level-item">Filtrovať</b-button>
        </div>
      </div>
    </b-collapse>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isOpen: true
    };
  }
};
</script>

<style>
.container {
  margin-top: 24px;
  padding: 0 0 !important;
  text-align: left;
}
.level-item {
  margin: 12px 12px;
}
</style>
