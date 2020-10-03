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
    <div v-if="loaded" class="carousel">
      <VueSlickCarousel v-bind="settings">
        <nuxt-link
          v-for="(item, id) in bookMeta"
          :key="id"
          :to="{
            path: '/book/' + item.id,
          }"
          class="column"
        >
          <p class="carouselTitle subtitle">
            {{ item.title }}
          </p>
          <img :src="item.sticker" />
        </nuxt-link>
      </VueSlickCarousel>
    </div>
    <div v-if="!loaded" class="carousel level"><Loading /></div>
  </div>
</template>
<script>
import VueSlickCarousel from 'vue-slick-carousel';
import 'vue-slick-carousel/dist/vue-slick-carousel.css';
import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css';
import Loading from '~/components/Loading';

export default {
  name: 'Carousel',
  components: { VueSlickCarousel, Loading },
  data() {
    return {
      settings: {
        arrows: true,
        dots: true,
        infinite: true,
        speed: 500,
        slidesToShow: 7,
        slidesToScroll: 1,
        touchThreshold: 5,
      },
      bookMeta: [],
      loaded: false,
    };
  },
  created() {
    this.$axios
      .get('http://localhost:8080/getBookMeta', {
        headers: { Authorization: `Bearer test` },
      })
      .then((response) => {
        this.bookMeta = response.data;
        this.loaded = true;
      });
  },
};
</script>
<style>
.carouselTitle {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  width: 70%;
  color: black;
}

.carousel {
  height: 265px;
}
</style>
