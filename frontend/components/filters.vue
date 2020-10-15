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
    return {
      bookName: this.$route.query['book-name']
        ? this.$route.query['book-name']
        : '',
      show: true,
      nameTimeout: null,
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
  methods: {
    toggleShow() {
      this.show = !this.show;
    },
    updateQuery() {
      console.log('ba');
      const newQuery = this.filterObject;
      this.$router.push({ path: '/books/', query: newQuery });
    },
  },
};
</script>

<style></style>
