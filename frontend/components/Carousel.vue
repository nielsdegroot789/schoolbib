<template>
  <div class="section">
    <div class="tabs is-centered is-boxed">
      <ul>
        <li class="is-active"><a>New adults</a></li>
        <li><a>New children</a></li>
        <li><a>New fantasy</a></li>
        <li><a>New fiction</a></li>
      </ul>
    </div>

    <div class="carousel columns">
      <button class="carousel-button">
        <font-awesome-icon :icon="['fas', 'angle-left']" />
      </button>
      <div
        v-for="(item, id) in bookMeta.slice(0, 7)"
        :key="id"
        class="column box"
      >
        <p class="carouselTitle">
          {{ item.title }}
        </p>
        <img :src="item.sticker" />
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
<style>
.carouselTitle {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  width: 70%;
}

.carousel .box {
  margin: 20px;
}
</style>
