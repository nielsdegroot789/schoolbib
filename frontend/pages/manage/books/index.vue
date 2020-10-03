<template>
  <div class="setup section">
    <header class="level">
      <h1 class="level-left title">Manage Books</h1>
      <nuxt-link :to="{ path: '/manage/books/new' }" class="button level-right"
        >new</nuxt-link
      >
    </header>
    <table class="table table is-bordered is-hoverable is-fullwidth">
      <thead>
        <tr>
          <th>title</th>
          <th>isbn</th>
          <th>publish Date</th>
          <th>rating</th>
          <th>total Pages</th>
          <th>sticker</th>
          <th>language</th>
          <th>reading Level</th>
          <th>authors</th>
          <th>publishers</th>
          <th>categories</th>
          <th>edit</th>
          <th>delete</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th>title</th>
          <th>isbn</th>
          <th>publish Date</th>
          <th>rating</th>
          <th>total Pages</th>
          <th>sticker</th>
          <th>language</th>
          <th>reading Level</th>
          <th>authors</th>
          <th>publishers</th>
          <th>categories</th>
          <th>edit</th>
          <th>delete</th>
        </tr>
      </tfoot>
      <tbody>
        <tr v-for="book in bookMeta" :key="book.id">
          <td>{{ book.title }}</td>
          <td>{{ book.isbnCode }}</td>
          <td>{{ book.publishDate }}</td>
          <td>{{ book.rating }}</td>
          <td>{{ book.totalPages }}</td>
          <td><img :src="book.sticker" alt="Book cover image" /></td>
          <td>{{ book.language }}</td>
          <td>{{ book.readingLevel }}</td>
          <td>{{ book.authors }}</td>
          <td>{{ book.publishers }}</td>
          <td>{{ book.categories }}</td>
          <td>
            <nuxt-link
              :to="{ path: '/manage/books/edit/' + book.id }"
              class="button"
            >
              edit
            </nuxt-link>
          </td>
          <td>
            <nuxt-link :to="/deleteBook/ + book.id" class="button"
              >delete</nuxt-link
            >
          </td>
        </tr>
      </tbody>
      <!-- <nuxt-link
        v-for="(item, index) in bookMeta"
        :key="index"
        class="booksContainer"
        :to="/book/ + item.id"
      >
        <span>{{ item.title }}</span>
        <span>{{ item.isbnCode }}</span>
        <span>{{ item.publishDate }}</span>
        <span>{{ item.rating }}</span>
        <span>{{ item.totalPages }}</span>
        <span>{{ item.sticker }}</span>
        <span>{{ item.language }}</span>
        <span>{{ item.readingLevel }}</span>
        <span>{{ item.authors }}</span>
        <span>{{ item.publishers }}</span>
        <span>{{ item.categories }}</span>
        <nuxt-link
          :to="{
            path: '/manage/books/edit/' + item.id,
          }"
        >
          edit</nuxt-link
        >
        <nuxt-link :to="/deleteBook/ + item.id">delete</nuxt-link>
      </nuxt-link>
      <button class="newBook">
        <nuxt-link
          :to="{
            path: '/manage/books/new',
          }"
          >new</nuxt-link
        >
      </button> -->
    </table>
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
  created() {},
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
  margin: 0 5%;
  box-sizing: border-box;
  height: 100%;
}

.links {
  padding-top: 15px;
}

.booksContainer:nth-child(odd) {
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

.booksContainer {
  display: grid;
  grid-template-columns: repeat(11, calc(90% / 11)) 5% 5%;
  justify-items: center;
  align-items: center;
  margin: 5px 0;
}

.booksContainer span {
  overflow-wrap: anywhere;
}
</style>
