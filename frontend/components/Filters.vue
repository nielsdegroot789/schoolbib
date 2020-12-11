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
      :batches="batches"
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
      categoryFilters: this.$route.query['filter-category']
        ? this.$route.query['filter-category']
        : [],
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
    // if array
    this.reload(this.authorFilters, 'Author');
    this.reload(this.categoryFilters, 'Category');
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
        this.batches.push({
          value: filterObject.val,
          type: filterObject.typ,
        });
        if (filterObject.typ === 'Categories') {
          this.categoryFilters.push(filterObject.val);
        } else {
          this.authorFilters.push(filterObject.val);
        }
      }
      this.emptyAutoList();
      this.updateQuery();
    },
    deleteQuery(value, type) {
      debugger;
      this.batches = this.batches.filter((batch) => {
        return batch.value !== value;
      });
      if (type === 'Category') {
        this.categoryFilters = this.categoryFilters.filter((categoryVal) => {
          return value !== categoryVal;
        });
      } else {
        this.authorFilters = this.authorFilters.filter((authorVal) => {
          return value !== authorVal;
        });
      }
      console.log(value);
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
    reload(arrayFilter, type) {
      if (arrayFilter) {
        if (Array.isArray(arrayFilter)) {
          arrayFilter.forEach((element) => {
            const batch = { value: element, type };
            this.batches.push(batch);
          });
        } else {
          const batch = { value: arrayFilter, type };
          this.batches.push(batch);
        }
      }
    },
  },
};
</script>

<style></style>
