<template>
  <div class="pagination-row">
    <n-link
      v-if="first !== false"
      :to="{ path: 'books', query: { page: '1' } }"
    >
      first
    </n-link>

    <n-link
      v-if="previous !== false"
      :to="{ path: 'books', query: { page: previous } }"
    >
      previous
    </n-link>

    <n-link
      v-for="page in pageButtons"
      :key="page"
      :to="{ path: 'books', query: { page: pageButtons } }"
    >
      {{ page }}
    </n-link>

    <n-link
      v-if="next !== false"
      :to="{ path: 'books', query: { page: next } }"
    >
      next
    </n-link>

    <n-link
      v-if="last !== false"
      :to="{ path: 'books', query: { page: last } }"
    >
      last
    </n-link>
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },
  computed: {
    totalBookMeta() {
      return this.$store.getters.getBookMetaCount;
    },
    pageNumber() {
      return parseInt(this.$route.query.page);
    },
    totalPages() {
      return this.totalBookMeta / this.limit;
    },
    pageButtons() {
      const start = Math.min(
        this.totalPages - 4,
        Math.max(1, this.pageNumber - 2),
      );
      const array = [];
      for (let i = start; i <= start + 5; i++) {
        array.push(i);
      }
      return array;
    },

    first() {
      if (this.pageNumber === 1) {
        return false;
      }
      return 1;
    },
    last() {
      if (this.pageNumber === this.totalPages) {
        return false;
      }
      return this.totalPages;
    },
    next() {
      if (this.pageNumber === this.totalItems) {
        return false;
      }
      return this.pageNumber + 1;
    },
    previous() {
      if (this.pageNumber === this.totalItems) {
        return false;
      }
      return this.pageNumber - 1;
    },
  },
  watch: {
    $route: {
      immediate: true,
      handler(route) {
        this.currentPage = route.query.name;
        this.$store.dispatch('getBookMeta', {
          pageNumber: this.pageNumber,
        });
        console.log(route);
      },
    },
  },
};
</script>

<style scoped>
.pagination-button {
  padding: 8px;
  margin: 2px;
  border-radius: 3px;
  font-size: 1em;
  cursor: pointer;
}

.pagination-button .active {
  background-color: rgb(24, 250, 250);
  cursor: auto;
}

.pagination-button .disabled {
  cursor: auto;
}
.pagination-row {
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
</style>
