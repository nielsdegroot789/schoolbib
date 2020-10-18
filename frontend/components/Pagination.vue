<template>
  <div>
    <div v-if="pagesCount > 1" class="pagination">
      <div class="pagination__back">
        <nuxt-link
          v-if="firstPage !== false"
          :to="pageConfig(firstPage)"
          class="PageLink"
          :disabled="isInFirstPage"
        >
          first
        </nuxt-link>
        <nuxt-link
          v-if="previousPage !== false"
          :to="pageConfig(previousPage)"
          class="PageLink"
        >
          previous
        </nuxt-link>
      </div>
      <div class="pagination__numbered">
        <nuxt-link
          v-for="page in pageButtons"
          :key="page"
          :to="pageConfig(page)"
          :disable="page == currentPage"
          :class="{
            pagination__link: true,
            'PageLink--active': page == currentPage,
          }"
        >
          {{ page }}
        </nuxt-link>
      </div>
      <div class="pagination__forward">
        <nuxt-link
          v-if="nextPage !== false"
          :to="pageConfig(nextPage)"
          class="PageLink"
          :disabled="isInLastPage"
        >
          next
        </nuxt-link>
        <nuxt-link
          v-if="lastPage !== false"
          :to="pageConfig(lastPage)"
          class="PageLink"
          :disabled="isInLastPage"
        >
          last
        </nuxt-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Pagination',
  computed: {
    currentPage() {
      return parseInt(this.$route.query.page);
    },
    pagesCount() {
      return this.$store.getters.pageCount;
    },
    amountOfButtons() {
      return Math.min(5);
    },
    pageButtons() {
      const start = Math.min(
        Math.max(1, this.pagesCount - 4),
        Math.max(1, this.currentPage - 2),
      );
      const array = [];
      for (let i = start; i < start + this.amountOfButtons; i++) {
        array.push(i);
      }
      return array;
    },
    firstPage() {
      if (this.currentPage <= 2) return false;

      return 1;
    },
    previousPage() {
      if (this.currentPage === 1) return false;

      return this.currentPage - 1;
    },
    nextPage() {
      if (this.currentPage === this.pagesCount) return false;

      return this.currentPage + 1;
    },
    lastPage() {
      if (this.currentPage >= this.pagesCount - 1) return false;

      return this.pagesCount;
    },
  },
  methods: {
    pageConfig(newPageNumber) {
      return {
        path: '/books/' + newPageNumber,
        query: this.$route.query,
      };
    },
  },
};
</script>

<style lang="css">
.pagination {
  padding: 1rem;
  display: flex;
  justify-content: space-between;
  border: 1px solid purple;
}
.PageLink {
  font-size: 1.8rem;
  padding: 0.5rem;
}
.PageLink__active {
  color: grey;
}
</style>
