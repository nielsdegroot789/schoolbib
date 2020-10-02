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

    <!-- <div class="carousel columns">
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
    </div> -->

    <VueSlickCarousel v-bind="settings" :arrows="true">
      <div v-for="(item, id) in bookMeta" :key="id" class="column box">
        <p class="carouselTitle">
          {{ item.title }}
        </p>
        <img :src="item.sticker" />
      </div>
    </VueSlickCarousel>
  </div>
</template>
<script>
import VueSlickCarousel from 'vue-slick-carousel';
import 'vue-slick-carousel/dist/vue-slick-carousel.css';
import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css';

export default {
  name: 'Carousel',
  components: { VueSlickCarousel },
  data() {
    return {
      settings: {
        dots: true,
        focusOnSelect: true,
        infinite: true,
        speed: 500,
        slidesToShow: 5,
        slidesToScroll: 1,
        touchThreshold: 5,
      },
    };
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
