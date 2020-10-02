<template>
  <div>
    <div id="carousel-links-container">
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
    </div>
    <div class="carousel-container">
      <button class="carousel-button">
        <font-awesome-icon :icon="['fas', 'angle-left']" />
      </button>
      <div
        v-for="(item, id) in bookMeta.slice(0, 7)"
        :key="id"
        class="carousel-book"
      >
        {{ item.title }}
      </div>
      <button class="carousel-button">
        <font-awesome-icon :icon="['fas', 'angle-right']" />
      </button>
    </div>
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
