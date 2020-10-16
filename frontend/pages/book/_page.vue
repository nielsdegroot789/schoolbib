<template>
  <main class="p-characters-list">
    <h1>Characters</h1>
    
    <Pagination root-path="/books/bookMetas/" />
  </main>
</template>

<script>
import CharacterList from '~/components/CharacterList';
import Pagination from '~/components/Pagination';
import Filters from '~/components/Filters';

export default {
  name: 'CharactersPage',
  components: {
    CharacterList,
    Pagination,
    Filters,
  },
  computed: {
    fetchingCharacters() {
      return this.$store.state.fetchingCharacters;
    },
    characters() {
      return this.$store.state.characters;
    },
    currentPage() {
      return parseInt(this.$route.params.page);
    },
    filters() {
      return {
        page: this.currentPage,
        filters: this.$route.query,
      };
    },
  },
  watch: {
    $route: {
      immediate: true,
      handler() {
        this.$store.dispatch('fetchCharacters', this.filters);
      },
    },
  },
};
</script>

<style lang="scss">
.p-characters-list {
  display: grid;
  gap: 2rem;

  h1 {
    margin: 0;
  }
}
</style>
