<template>
  <div class="section">
    <div class="tabs is-centered is-boxed">
      <ul>
        <li
          v-for="category in categories"
          :key="category.id"
          :class="currentlyActive === category.id && 'is-active'"
          @click="setCurrentTab(category.id)"
        >
          <a>{{ category.name }}</a>
        </li>
      </ul>
    </div>
    <div v-if="loaded && bookMeta.length > 0" class="carousel">
      <VueSlickCarousel v-bind="settings">
        <nuxt-link
          v-for="item in bookMeta"
          :key="item.id"
          :to="'/book/' + item.id"
          class="column"
        >
          <p class="carouselTitle subtitle">
            {{ item.title }}
          </p>
          <img :src="item.sticker" />
        </nuxt-link>
      </VueSlickCarousel>
    </div>
    <div v-else-if="!loaded" class="carousel level"><Loading /></div>
    <div v-else>
      Sorry, there are currently no books available in this category
    </div>
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
      categories: [
        { id: 0, value: 'Computers', name: 'Computers' },
        { id: 1, value: 'Cooking', name: 'Cooking' },
        { id: 2, value: 'Juvenile Nonfiction', name: 'Juvenile Nonfiction' },
        { id: 3, value: 'Fiction', name: 'Fiction' },
      ],
      currentlyActive: 0,
      bookMeta: [],
      loaded: false,
    };
  },
  created() {
    this.getBookMeta();
  },
  methods: {
    setCurrentTab(newId) {
      this.currentlyActive = newId;
      this.getBookMeta();
    },
    getBookMeta() {
      this.loaded = false;
      const params = {};
      params.categories = this.categories[this.currentlyActive].value;
      this.$axios
        .get('getBookMeta', {
          params,
        })
        .then((response) => {
          this.bookMeta = response.data;
          this.loaded = true;
        });
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
  color: black;
}

.carousel {
  height: 265px;
}

.slick-prev,
.slick-next {
  height: 60px;
  background-color: lightgray;
}

.slick-prev:before,
.slick-next:before {
  color: white;
  font-family: unset;
  font-size: 30px;
  background-color: transparent;
}

.slick-prev:before {
  float: left;
}

.slick-next:before {
  float: right;
}

.slick-prev:hover,
.slick-prev:focus,
.slick-next:hover,
.slick-next:focus {
  background-color: lightgray;
}

.slick-track {
  margin: auto;
}
</style>
