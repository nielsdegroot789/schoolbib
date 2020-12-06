<template>
  <div
    :class="{
      'container-filters': true,
    }"
  >
    <Autocomplete
      v-if="show"
      name="Filters"
      :disabled="fetchingInitLabel"
      @change="searchFilter"
      @select="updateFilterQuery"
      @delete="deleteQuery"
    />
    <div v-if="this.$route.path == '/books'" class="filters__toggle">
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
      filterCategories: [],
      filterAuthors: [],
      show: true,
    };
  },
  computed: {
    filterObject() {
      const query = {};
      query['filter-category'] = this.$store.state.batches.reduce(function (
        filtered,
        batch,
      ) {
        if (batch.type === 'Categories') {
          filtered.push(batch.value);
        }
        return filtered;
      },
      []);

      query['filter-authors'] = this.$store.state.batches.reduce(function (
        filtered,
        batch,
      ) {
        if (batch.type === 'Authors') {
          filtered.push(batch.value);
        }
        return filtered;
      },
      []);

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
    this.queryReload(this.$route.query['filter-category'], 'Categories');
    this.queryReload(this.$route.query['filter-authors'], 'Authors');
  },
  methods: {
    toggleShow() {
      this.show = !this.show;
    },
    updateQuery() {
      const newQuery = this.filterObject;
      console.log(newQuery);
      this.$router.push({
        path: '/books',
        query: newQuery,
      });
    },
    searchFilter(input) {
      if (input.length === 0) {
      }
    },
    updateFilterQuery(filterObject) {
      if (filterObject !== null) {
        if (filterObject.type === 'Categories') {
          this.filterCategories.push(filterObject);
        } else {
          this.filterAuthors.push(filterObject);
        }
      }

      this.updateQuery();
    },
    deleteQuery() {
      this.updateQuery();
    },
    queryReload(routeQuery, typeQuery) {
      if (routeQuery) {
        if (Array.isArray(routeQuery)) {
          routeQuery.map((val) => {
            this.$store.dispatch('addBatch', { value: val, type: typeQuery });
          });
        } else {
          this.$store.dispatch('addBatch', {
            value: routeQuery,
            type: typeQuery,
          });
        }
      }
    },
  },
};
</script>

<style></style>
