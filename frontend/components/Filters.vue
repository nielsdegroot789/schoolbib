<template>
  <div
    :class="{
      'c-filters': true,
    }"
  >
    <div v-if="show" class="c-filters__content">
      <div class="c-filters__name">
        <label>
          Name:
          <input v-model="bookName" type="text" />
        </label>
      </div>
    </div>
    <div class="c-filters__toggle">
      <button class="button button-clear" @click="toggleShow">
        {{ show ? 'Hide filters' : 'Show filters' }}
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Filters',
  data() {
    let filterIds = [];
    if (this.$route.query['filter-id']) {
      filterIds = this.$route.query['filter-id'].map((val) => {
        return {
          value: val,
          label: 'loading...',
        };
      });
    }

    return {
      bookName: this.$route.query['book-name']
        ? this.$route.query['book-name']
        : '',
      nameTimeout: null,
      filterIds,
      FilterOptions: [],
      fetchingFilters: false,
      initLabel: '',
      show: true,
    };
  },
  computed: {
    filterObject() {
      const query = {};

      if (this.bookName) {
        query['book-name'] = this.bookName;
      }

      if (this.filterIds) {
        query['filter-id'] = this.filterIds.map((val) => val.value);
      }

      return query;
    },
  },
  watch: {
    bookName() {
      clearTimeout(this.nameTimeout);
      this.nameTimeout = setTimeout(this.updateQuery, 1000);
    },
  },
  methods: {
    async fetchComicLabel(comicId) {
      const params = {
        apikey: this.$store.state.apiKey,
      };

      try {
        this.fetchingComics = true;
        const response = await this.$axios({
          method: 'GET',
          url: 'https://gateway.marvel.com:443/v1/public/comics/' + comicId,
          params,
        });

        if (!response.data.data.results[0]) {
          throw new Error('Comic not found');
        }

        const label = response.data.data.results[0].title;
        this.comicIds.map((comic) => {
          if (comic.value === comicId) {
            comic.label = label;
          }
        });
      } catch (error) {
        console.error(error);
        this.comicId = null;
        this.updateQuery();
      }
    },
    toggleShow() {
      this.show = !this.show;
    },
    updateQuery() {
      console.log(this.filterObject);
      const newQuery = this.filterObject;

      this.$router.push({
        path: '/books',
        query: newQuery,
      });
    },
    async searchComics(comicTitle) {
      if (comicTitle.length === 0) {
        return;
      }

      const params = {
        apikey: this.$store.state.apiKey,
        limit: 10,
        titleStartsWith: comicTitle,
      };

      try {
        this.fetchingComics = true;
        const response = await this.$axios({
          method: 'GET',
          url: 'https://gateway.marvel.com:443/v1/public/comics',
          params,
        });

        this.comicOptions = response.data.data.results.map(function (comic) {
          return {
            value: comic.id,
            label: comic.title,
          };
        });
      } catch (error) {
        console.error(error);
      }
      this.fetchingComics = false;
    },
    updateComicId(comic) {
      if (comic !== null) {
        this.comicIds.push(comic);
      }
      this.comicOptions = [];
      this.updateQuery();
    },
    removeComicId(comicId) {
      const index = this.comicIds.reduce((index, comic, curIndex) => {
        if (comic.value === comicId) {
          return curIndex;
        }

        return index;
      }, -1);

      if (index === -1) {
        return;
      }

      this.comicIds.splice(index, 1);
      this.updateQuery();
    },
  },
};
</script>

<style></style>
