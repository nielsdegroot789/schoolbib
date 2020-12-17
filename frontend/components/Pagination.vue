<template>
  <div v-if="pagesCount > 1">
    <div class="pagination">
      <n-link :to="{ path: 'books', query: { page: first } }">
        &lt; &lt;
      </n-link>

      <n-link :to="{ path: 'books', query: { page: previous } }"> &lt; </n-link>

      <n-link
        v-for="page in pageButtons"
        :key="page"
        :to="{ path: 'books', query: { page: page } }"
      >
        {{ page }}
      </n-link>

      <n-link class="next" :to="{ path: 'books', query: { page: next } }">
        &gt;
      </n-link>

      <n-link :to="{ path: 'books', query: { page: last } }">
        &gt; &gt;
      </n-link>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    totalitems: {
      type: Number,
      required: true,
    },
    limit: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {};
  },
  computed: {
    pagesCount() {
      return Math.ceil(this.totalitems / this.limit);
    },

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
          pageNumber: this.pageNumber,
        };
        this.$store.dispatch('getBookMeta', payload);
      },
    },
  },
};
</script>

<style>
.pagination {
  display: inline-block;
  margin: 20px;
}

.pagination * {
  color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
  border: 0.5px rgb(119, 118, 118) solid;
  border-radius: 0.5px;
}
</style>
