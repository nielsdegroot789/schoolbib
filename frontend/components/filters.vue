<template>
  <div :class="{ 'filter-container': true }">
    <div v-if="show" class="filters-content">
      <div class="c-filters-name">
        <label>
          Name:
          <input v-model="bookName" type="text" />
        </label>
      </div>
      <Autocomplete
        :value="filterIds"
        :loading="fetchingFilters"
        :options="filterOptions"
        :disabled="fetchingInitLabel"
        @change="searchFilters"
        @remove="removeFilterId"
        @select="updateFilterId"
      />
    </div>
    <div class="filters-toggle">
      <button class="button button-clear" @click="toggleShow">
        {{ show ? 'Hide filters' : 'Show filters' }}
      </button>
    </div>
  </div>
</template>

<script>
import Autocomplete from '../components/AutoComplete';
export default {
  name: 'Filter',
  components: {
    Autocomplete,
  },
  data() {
    return {
      bookName: this.$route.query['book-name']
        ? this.$route.query['book-name']
        : '',
      show: true,
      nameTimeout: null,
      filterOptions: [],
      fetchingFilters: false,
    };
  },
  computed: {
    filterObject() {
      const query = {};
      if (this.bookName) {
        query['book-name'] = this.bookName;
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
    for (const filter of this.filterIds) {
      this.fetchComicLabel(filter.value);
    }
  },
  methods: {
    toggleShow() {
      this.show = !this.show;
    },
    updateQuery() {
      console.log('ba');
      const newQuery = this.filterObject;
      this.$router.push({ path: '/books/', query: newQuery });
    },
    updateFilterId(filter) {
      if (filter !== null) {
        this.filterIds.push(filter);
      }
      this.filterOptions = [];
      this.updateQuery();
    },
    async searchFilters(filterValue) {
      if (filterValue.length === 0) {
        return;
      }
      const params = {
        title: filterValue,
      };

      try {
        this.fetchingFilters = true;
        const response = await this.$axios({
          method: 'GET',
          url: 'http://localhost:8080/getBooksMeta',
          params,
        });
        this.filterOptions = response.data.map(function (filter) {
          return {
            value: filter.id,
            label: filter.name,
          };
        });
      } catch (error) {
        console.log(error);
      }
      this.fetchingFilters = false;
    },
  },
};
</script>

<style></style>
