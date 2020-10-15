<template>
  <div :class="{ 'filter-container': true }">
    <div v-if="show" class="filters-content">
      <div class="c-filters-name">
        <label>
          Name:
          <input v-model="bookName" type="text" />
        </label>
      </div>
    </div>
    <div class="filters-toggle">
      <button class="button button-clear" @click="toggleShow">
        {{ show ? 'Hide filters' : 'Show filters' }}
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Filter',
  data() {
    let bookIds = [];
    if (this.$route.query['book-id']) {
      bookIds = this.$route.query['book-id'].map((val) => {
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
      bookIds,
      show: true,
    };
  },
  computed: {
    filterObject() {
      const query = [];
      if (this.bookName) {
        query['book-name'] = this.bookName;
      }
      return query;
    },
  },
  methods: {
    toggleShow() {
      this.show = !this.show;
    },
  },
  updateQuery() {
    const newQuery = this.filterObject;

    this.$router.push({ path: '/books', query: newQuery });
  },
  async searchBooks(bookTitle) {
    if (bookTitle.length === 0) {
      return;
    }

    const params = {
      limit: 25,
      titleName: bookTitle,
    };

    try {
      this.fetchingBooks = true;
      const response = await this.$axios({
        method: 'GET',
        url: 'http://localhost:8080/searchBooks',
        params,
      });
    } catch (error) {
      console.error(error);
    }
    this.fetchinBooks = true;
  },
};
</script>

<style></style>
