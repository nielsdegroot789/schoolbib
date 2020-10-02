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
      <div>1</div>
      <div>2</div>
      <div>3</div>
      <div>4</div>
      <div>5</div>
      <div>6</div>
      <div>7</div>
      <div>8</div>
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
        slidesToShow: 3,
        slidesToScroll: 3,
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
