<template>
  <!-- <div v-if="pagesCount > 1" class="pagination-row"> -->
  <div class="pagination-row">
    <n-link :to="{ path: 'books', query: { page: first } }"> first </n-link>

    <n-link :to="{ path: 'books', query: { page: previous } }">
      previous
    </n-link>

    <n-link
      v-for="page in pageButtons"
      :key="page"
      :to="{ path: 'books', query: { page: pageButtons } }"
    >
      {{ page }}
    </n-link>

    <n-link :to="{ path: 'books', query: { page: next } }"> next </n-link>

    <n-link :to="{ path: 'books', query: { page: last } }"> last </n-link>
  </div>
</template>

<script>
export default {
  props: {
    pageCount: {
      type: number,
      default: 0,
    },
  },
  data() {
    return {};
  },
  computed: {
    pageNumber() {
      return parseInt(this.$route.query.page);
    },

    amountOfButtons() {
      return Math.min(this.pagesCount, 5);
    },
    pageButtons() {
      const start = Math.min(
        Math.max(1, this.pagesCount - 4),
        Math.max(1, this.pageNumber - 2),
      );
      const array = [];
      for (let i = start; i < start + this.amountOfButtons; i++) {
        array.push(i);
      }
      return array;
    },

    first() {
      if (this.pageNumber === 1) {
        return 1;
      }
      return 1;
    },
    last() {
      if (this.pageNumber >= this.pagesCount - 1) {
        return this.pagesCount;
      }
      return this.pagesCount;
    },
    next() {
      if (this.pageNumber === this.pagesCount) {
        return false;
      }
      return this.pageNumber + 1;
    },
    previous() {
      if (this.pageNumber === 1) {
        return 1;
      }
      return this.pageNumber - 1;
    },
  },
  watch: {
    $route: {
      immediate: true,
      handler(route) {
        const payload = {
          page: route.query.name,
          pageNumber: this.pageNumber,
        };
        this.$store.dispatch('getBookMeta', payload);
      },
    },
  },
};
</script>

<style scoped>
.disabled {
  color: lightgrey;
  pointer-events: none;
}

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
