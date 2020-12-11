<template>
  <div class="section pageSetup">
    <div class="section level">
      <Filters />
    </div>
    <Pagination
      :totalitems="metaCountBooks"
      :limit="limit"
      class="level-right"
    />
    <div class="cardContainer">
      <nuxt-link
        v-for="item in bookMeta"
        :key="item.id"
        class="card"
        :to="'/book/' + item.id"
      >
        <div class="card-content">
          <div class="media">
            <div class="media-left">
              <figure class="image is-96x96">
                <img
                  :src="item.sticker"
                  :alt="'cover photo of ' + item.title"
                />
              </figure>
            </div>
            <div class="media-content">
              <p class="bookTitle title is-5">{{ item.title }}</p>
              <p class="title is-6">
                <StarRating v-if="item.rating" :rating="item.rating" />
                <span v-if="!item.rating">Rating unavailable</span>
              </p>
            </div>
          </div>
          <div class="content">{{ item.categories }}</div>
        </div>
      </nuxt-link>
    </div>
  </div>
</template>
<script>
import Filters from '../components/Filters';
import StarRating from '~/components/StarRating';
import Pagination from '~/components/Pagination';

export default {
  components: {
    StarRating,
    Pagination,
    Filters,
  },
  data() {
    return {
      search: '',
      timeoutId: null,
      filterTimeOut: null,
      metaCountBooks: 0,
      limit: 0,
    };
  },
  computed: {
    bookMeta() {
      return this.$store.state.bookMeta;
    },
    filters() {
      return { filters: this.$route.query };
    },
  },

  watch: {
    $route: {
      immediate: true,
      handler() {
        this.$store.dispatch('getBookMeta', this.filters);
      },
    },
  },
  created() {
    this.getBookMetaCount();
  },
  methods: {
    getBookMetaCount() {
      this.$axios
        .get('http://localhost:8080/getBookMetaCount')
        .then(
          (response) => (this.metaCountBooks = response.data[0]['count(id)']),
        );
    },
    toSearch() {
      clearTimeout(this.filterTimeOut);
      this.filterTimeOut = setTimeout(() => {
        this.$router.push({ path: '/catalog/', query: { name: this.search } });
      }, 1000);
    },
  },
};
</script>

<style scoped>
.pageSetup {
  padding-left: 5%;
  padding-right: 5%;
}

.noOverflow {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.cardContainer {
  display: grid;
  margin: 0 auto;
  grid-template-columns: repeat(4, 24%);
  column-gap: 1%;
  row-gap: 50px;
}

.rating {
  color: grey;
  font-size: 22px;
}

.borrow {
  border: none;
  outline: 0;
  padding: 12px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
  font-size: 18px;
}

.borrow:hover {
  opacity: 0.7;
}

input[type='text'] {
  display: flex;
  width: 600px;
  justify-content: space-between;
  text-align: center;
  margin-bottom: 50px;
  height: 4rem;
  padding-left: 1rem;
  background-color: #f9f9f9;
  color: black;
  width: 700px;
  border: 0;
  border-radius: 3px;
  border-color: black;
  border-width: 0.5px;
  border-style: dotted;
  padding: 10px;
}

img {
  height: 100%;
  width: auto;
}

.bookTitle {
  height: 50px;
}
.level-right {
  justify-content: center;
}
</style>
