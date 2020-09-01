<template>
  <div class="carousel-container">
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
