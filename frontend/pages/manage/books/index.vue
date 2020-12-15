<template>
  <div class="setup section">
    <deleteModal :books="bookMeta" @setNewBookMeta="newBookMeta" />
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
            <button class="button" @click="toggleDeleteModal(book.id)">
              delete
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import deleteModal from '~/components/deleteBook';
export default {
  components: {
    deleteModal,
  },
  data() {
    return {
      bookMeta: [],
    };
  },
  mounted() {
    this.$axios
      .get('http://localhost:8080/getBookMeta', {
        Auth: this.$store.JWT,
      })
      .then((response) => {
        this.bookMeta = response.data;
      });
  },
  created() {
    this.$store.dispatch('getBookMeta');
  },
  methods: {
    toggleDeleteModal(id) {
      this.$store.dispatch('setDeleteId', id);
      this.$store.dispatch('toggleDeleteModal');
    },
    newBookMeta(newBookMeta) {
      this.bookMeta = newBookMeta;
    },
  },
};
</script>

<style>
.setup {
  margin: 0 5%;
  box-sizing: border-box;
  height: 100%;
  overflow-x: auto;
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
</style>
