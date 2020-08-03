<template>
  <div class="container">
    <div>
      <div class="headerContainer bold">
        <span>title</span>
        <span>isbn</span>
        <span>publishDate</span>
        <span>rating</span>
        <span>totalPages</span>
        <span>sticker</span>
        <span>language</span>
        <span>readingLevel</span>
        <span>authors</span>
        <span>publishers</span>
        <span>categories</span>
      </div>

      <div v-for="(item, index) in books" :key="index" class="booksContainer">
        <nuxt-link :to="/book/ + item.id">
          <span>{{ item.title }}</span>
          <span>{{ item.isbnCode }}</span>
          <span>{{ item.publishDate }}</span>
          <span>{{ item.rating }}</span>
          <span>{{ item.totalPages }}</span>
          <span>{{ item.sticker }}</span>
          <!-- //cover? -->
          <span>{{ item.language }}</span>
          <span>{{ item.readingLevel }}</span>
          <span>{{ item.authors }}</span>
          <span>{{ item.publishers }}</span>
          <span>{{ item.categories }}</span>
        </nuxt-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },
  computed: {
    books() {
      return this.$store.state.books;
    },
  },
  mounted() {
    //   axios
    //     .get('http://localhost:8080/')
    //     .then((response) => (this.books = response.data));
    // },
    this.$store.dispatch('getBooks');
  },
};
</script>

<style>
.container {
  margin: 0 auto;
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
}

.title {
  font-family: 'Quicksand', 'Source Sans Pro', -apple-system, BlinkMacSystemFont,
    'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
  display: block;
  font-weight: 300;
  font-size: 100px;
  color: #35495e;
  letter-spacing: 1px;
}

.subtitle {
  font-weight: 300;
  font-size: 42px;
  color: #526488;
  word-spacing: 5px;
  padding-bottom: 15px;
}

.links {
  padding-top: 15px;
}

.travelContainer {
  width: 100%;
}

.travelContainer > :nth-child(odd) {
  background-color: lightgray;
}

.headerContainer {
  display: grid;
  grid-template-columns: repeat(11, calc(100% / 11));
  justify-items: center;
  align-items: center;
  margin: 5px 0;
  font-weight: bold;
}

.booksContainer a {
  display: grid;
  grid-template-columns: repeat(11, calc(100% / 11));
  justify-items: center;
  align-items: center;
  margin: 5px 0;
}
</style>
