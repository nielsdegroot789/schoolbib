<template>
  <div
    :class="{
      'container-filters': true,
    }"
  >
    <div v-if="show" class="filters__content">
      <div class="filters__name">
        <label>
          Name:
          <input v-model="bookName" type="text" />
        </label>
      </div>
      <Autocomplete
        name="Filters"
        :value="filterIds"
        :loading="fetchingFilters"
        :init-label="initLabel"
        :disabled="fetchingInitLabel"
        @change="searchFilter"
        @select="updateFilterQuery"
      />
    </div>
    <div class="filters__toggle">
      <button class="button button-clear" @click="toggleShow">
        {{ show ? 'Hide filters' : 'Show filters' }}
      </button>
    </div>
  </div>
</template>

<script>
import Autocomplete from '../components/Autocomplete';
export default {
  name: 'Filters',
  components: {
    Autocomplete,
  },
  data() {
    const filterCategories = [];
    return {
      bookName: this.$route.query['book-name']
        ? this.$route.query['book-name']
        : '',
      nameTimeout: null,
      FilterOptions: [],
      filterCategories,
      filterAuthors: [],
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

      if (this.filterCategories) {
        query['filter-category'] = this.$store.state.batches.map(
          (val) => val.value,
        );
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
  created() {
    if (this.$route.query['filter-category']) {
      if (Array.isArray(this.$route.query['filter-category'])) {
        this.$route.query['filter-category'].map((val) => {
          this.$store.dispatch('addBatch', { value: val, type: 'categories' });
        });
      } else {
        this.$store.dispatch('addBatch', {
          value: this.$route.query['filter-category'],
          type: 'categories',
        });
      }
    }
  },
  methods: {
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
    searchFilter(input) {
      if (input.length === 0) {
        return;
      }
      console.log(input);
      this.fetchingFilters = false;
    },
    updateFilterQuery(val) {
      console.log(val);
      if (val !== null) {
        this.filterCategories.push(val);
      }
      this.filterOptions = [];
      this.updateQuery();
    },
  },
};
</script>

<style></style>
