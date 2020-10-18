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
        @select="updateFilterId"
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
    return {
      bookName: this.$route.query['book-name']
        ? this.$route.query['book-name']
        : '',
      nameTimeout: null,
      FilterOptions: [],
      filterCategories: '',
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
    updateFilterId(filter) {
      if (filter !== null) {
        this.filterIds.push(filter);
      }
      this.filterOptions = [];
      this.updateQuery();
    },
  },
};
</script>

<style></style>
