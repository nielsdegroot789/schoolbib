<template>
  <div
    :class="{
      'container-filters': true,
    }"
  >
    <Autocomplete
      v-if="show"
      ref="reloadBatch"
      name="Filters"
      :batches="batchess"
      :authors="authorList"
      :categories="categoryList"
      @change="searchFilter"
      @select="updateFilterQuery"
      @loadResults="loadSearchResult"
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
      show: true,
      authorList: '',
      titleList: '',
      categoryList: '',
      authorFilters: this.$route.query['filter-authors']
        ? this.$route.query['filter-authors']
        : [],
      categoryFilters: [],
      batches: [],
    };
  },
  computed: {
    filterObject() {
      const query = {};
      if (this.categoryFilters) {
        query['filter-category'] = this.categoryFilters;
      }

      if (this.authorFilters) {
        query['filter-authors'] = this.authorFilters;
      }

      return query;
    },
  },
  mounted() {
    document.addEventListener('click', this.emptyAutoList);
  },
  beforeDestroy() {
    document.removeEventListener('click', this.emptyAutoList);
  },
  created() {
    debugger;
    // if array
    this.authorFilters.forEach((author) => {
      const batch = { value: author, type: 'Author' };
      this.batches.push(batch);
    });
    for (const category in this.categoryFilters) {
      const batch = { value: category, type: 'Category' };
      this.batch.push(batch);
    }
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
        if (filterObject.typ === 'Categories') {
          this.categoryFilters.push(filterObject.val);
        } else {
          this.authorFilters.push(filterObject.val);
        }
      }
      this.emptyAutoList();
      this.updateQuery();
    },
    deleteQuery() {
      this.updateQuery();
    },
    loadSearchResult(label) {
      this.$axios({
        method: 'GET',
        url: 'http://localhost:8080/getFilterResults',
        params: label,
      }).then((response) => {
        this.authorList = response.data.filter((book) => {
          return book.type === 'Authors';
        });
        this.titleList = response.data.filter((book) => {
          return book.type === 'Title';
        });
        this.categoryList = response.data.filter((book) => {
          return book.type === 'Categories';
        });
      });
    },
    emptyAutoList() {
      this.authorList = '';
      this.categoryList = '';
      this.titleList = '';
    },
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
};
</script>

<style></style>
