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
      <VueSlickCarousel v-bind="smallSettings" class="smallCarousel">
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

      <VueSlickCarousel v-bind="mediumSettings" class="mediumCarousel">
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

      <VueSlickCarousel v-bind="largeSettings" class="largeCarousel">
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
      smallSettings: {
        arrows: true,
        dots: false,
        infinite: true,
        speed: 500,
        slidesToShow: 2,
        slidesToScroll: 2,
        touchThreshold: 5,
      },
      mediumSettings: {
        arrows: true,
        dots: false,
        infinite: true,
        speed: 500,
        slidesToShow: 4,
        slidesToScroll: 1,
        touchThreshold: 5,
      },
      largeSettings: {
        arrows: true,
        dots: false,
        infinite: true,
        speed: 500,
        slidesToShow: 7,
        slidesToScroll: 1,
        touchThreshold: 5,
      },
      categories: [
        { id: 0, value: 'Fiction', name: 'Fiction' },
        { id: 1, value: 'Drama', name: 'Drama' },
        { id: 2, value: 'Gardening', name: 'Gardening' },
        { id: 3, value: 'Study Aids', name: 'Study Aids' },
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
  width: 100%;
  color: black;
}

.carousel {
  height: 265px;
}

.slick-prev,
.slick-next {
  height: 60px;
  background-color: #9bb2dd;
  width: 30px;
}

.slick-prev:hover,
.slick-next:hover {
  background-color: rgb(104, 147, 228) !important;
}

.slick-prev:focus,
.slick-next:focus {
  background-color: rgb(104, 147, 228) !important;
}

.slick-prev:before,
.slick-next:before {
  color: white;
  font-family: unset;
  font-size: 30px;
  background-color: transparent;
  float: unset;
  margin: auto;
}
.slick-track {
  margin: auto;
}

@media only screen and (min-width: 200px) {
  .carouselTitle {
    font-size: 0.75rem !important;
  }

  .tabs {
    font-size: 0.75rem;
  }

  .smallCarousel {
    display: block !important;
  }

  .mediumCarousel {
    display: none !important;
  }

  .largeCarousel {
    display: none !important;
  }
}

@media only screen and (min-width: 570px) {
  .carouselTitle {
    font-size: 1rem !important;
  }

  .tabs {
    font-size: 1rem;
  }
  .smallCarousel {
    display: none !important;
  }

  .mediumCarousel {
    display: block !important;
  }

  .largeCarousel {
    display: none !important;
  }
}

@media only screen and (min-width: 880px) {
  .carouselTitle {
    font-size: 1rem !important;
  }

  .tabs {
    font-size: 1.2rem;
  }
  .smallCarousel {
    display: none !important;
  }

  .mediumCarousel {
    display: none !important;
  }

  .largeCarousel {
    display: block !important;
  }
}
</style>
