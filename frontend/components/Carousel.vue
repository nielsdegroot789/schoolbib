<template>
  <div class="carousel-container">
    <ul class="carousel-new-suggestions">
      <li class="carousel-link">
        <h2 class="carousel-link-title">New adults</h2>
      </li>
      <li class="carousel-link">
        <h2 class="carousel-link-title">New children</h2>
      </li>
      <li class="carousel-link">
        <h2 class="carousel-link-title">New fantasy</h2>
      </li>
      <li class="carousel-link">
        <h2 class="carousel-link-title">New fiction</h2>
      </li>
    </ul>
    <button class="carousel-button">
      <font-awesome-icon :icon="['fas', 'angle-left']" />
    </button>
    <div v-for="(item, id) in bookMeta" :key="id" class="carousel-book">
      {{ item.title }}
    </div>
    <div class="carousel-book"></div>
    <div class="carousel-book"></div>
    <div class="carousel-book"></div>
    <div class="carousel-book"></div>
    <button class="carousel-button">
      <font-awesome-icon :icon="['fas', 'angle-right']" />
    </button>
  </div>
</template>
<script>
export default {
  name: 'Carousel',
  data() {
    return {};
  },
  computed: {
    bookMeta() {
      return this.$store.state.bookMeta;
    },
  },
};
</script>
<style></style>
