<template>
  <div class="setup">
    <h1 class="crudHeader crudTitle">Manage Books</h1>
    <div>
      <div class="headerContainer bold">
        <span>title</span>
        <span>isbn</span>
        <span>publish Date</span>
        <span>rating</span>
        <span>total Pages</span>
        <span>sticker</span>
        <span>language</span>
        <span>reading Level</span>
        <span>authors</span>
        <span>publishers</span>
        <span>categories</span>
        <span>edit</span>
        <span>delete</span>
      </div>

      <div
        v-for="(item, index) in bookMeta"
        :key="index"
        class="booksContainer"
      >
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
          <span>
            <nuxt-link :to="/editBook/ + item.id">edit</nuxt-link>
          </span>
          <span>
            <nuxt-link :to="/deleteBook/ + item.id">delete</nuxt-link>
          </span>
        </nuxt-link>
      </div>
      <button class="newBook">
        <nuxt-link to="/book/new">new</nuxt-link>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },
  computed: {
    bookMeta() {
      return this.$store.state.bookMeta;
    },
  },
};
</script>

<style>
.crudTitle {
  font-family: 'Quicksand', 'Source Sans Pro', -apple-system, BlinkMacSystemFont,
    'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
  display: block;
  font-weight: 300;
  font-size: 35px;
  color: #35495e;
  letter-spacing: 1px;
}

.setup {
  margin: 0 10%;
  box-sizing: border-box;
  height: 100%;
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
  grid-template-columns: repeat(11, calc(90% / 11)) 5% 5%;
  justify-items: center;
  align-items: center;
  margin: 5px 0;
  font-weight: bold;
}

.booksContainer a {
  display: grid;
  grid-template-columns: repeat(11, calc(90% / 11)) 5% 5%;
  justify-items: center;
  align-items: center;
  margin: 5px 0;
}
</style>
