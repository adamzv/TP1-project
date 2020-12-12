<template>
  <section class="hero is-medium">
    <div class="hero-body">
      <div class="container has-text-centered">
        <h1 class="title is-uppercase">{{ $t("not_found.page_not_found") }}</h1>
        <b-button
          class="subtitle"
          tag="router-link"
          :to="{ path: '/' }"
          icon-left="redo-variant"
        >
          {{ $t("not_found.back_to_main") }}
        </b-button>
      </div>
    </div>
  </section>
</template>

<script>
export default {};
</script>

<style></style>
