<template>
  <div class="setup section">
    <header class="level">
      <h1 class="level-left title">
        Wishlits. this could be a carousel with books that are you favorite.
      </h1>
    </header>
    <table class="table table is-bordered is-hoverable is-fullwidth aboveBlock">
      <thead>
        <tr>
          <th>Title</th>

          <th>Pages</th>
          <th>level</th>
          <th>rating</th>
          <th>cover</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in dataFavBook" :key="item.id">
          <td>{{ item.title }}</td>
          <td>{{ item.totalPages }}</td>
          <td>{{ item.readingLevel }}</td>
          <td>{{ item.rating }}</td>
          <td><img :src="item.sticker" alt="Book cover image" /></td>
          <button class="deleteButton" @click.stop="deleteFavBooks(item.id)">
            Delete
          </button>
        </tr>
      </tbody>
    </table>
    <table class="table table is-bordered is-hoverable is-fullwidth underBlock">
      <thead>
        <tr>
          <th>Authors U like</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="(item, index) in dataFavAuthor" :key="index">
          <td>
            {{ item.name }}
            <button class="deleteButton" @click.stop="deleteFavAuth(item.id)">
              Delete
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  data() {
    return {
      dataFavAuthor: [],
      dataFavBook: [],
    };
  },
  computed: {
    UserId() {
      return this.$store.state.currentUser;
    },
    JWT() {
      return this.$store.state.JWT;
    },
  },

  mounted() {
    axios
      .get('http://localhost:8080/getFavoriteAuthors', {
        headers: {
          Auth: localStorage.getItem('JWT'),
        },
      })
      .then((response) => {
        console.log(response);
        this.dataFavAuthor = response;
      });
    axios
      .get('http://localhost:8080/getFavoriteBooks', {
        headers: {
          Auth: localStorage.getItem('JWT'),
        },
      })
      .then((response) => {
        console.log(response.data);
        this.dataFavBook = response.data;
      });
  },
  methods: {
    deleteFavAuth(id) {
      axios
        .delete('http://localhost:8080/deleteFavoriteAuthors', {
          headers: {
            Auth: this.$store.state.JWT,
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          data: { data: id },
        })
        .then((response) => {
          this.refreshAuth();
        });
    },
    deleteFavBooks(id) {
      axios
        .delete('http://localhost:8080/deleteFavoriteBooks', {
          headers: {
            Auth: this.$store.state.JWT,
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          data: { data: id },
        })
        .then((response) => {
          this.refreshBooks();
        });
    },
    refreshAuth() {
      axios
        .get('getFavoriteAuthors', {
          params: {
            data: this.UserId,
            headers: {
              Auth: this.$store.state.JWT,
            },
          },
        })
        .then((response) => {
          this.dataFavAuthor = response.data;
        });
    },
    refreshBooks() {
      axios
        .get('http://localhost:8080/getFavoriteBooks', {
          params: {
            data: this.UserId,
            headers: {
              Auth: this.$store.state.JWT,
            },
          },
        })
        .then((response) => {
          this.dataFavBook = response.data;
        });
    },
  },
};
</script>

<style scoped>
.deleteButton {
  margin-left: 50px;
  display: inline-block;
  padding: 0.7em 1.4em;
  margin: 0 0.3em 0.3em 0;
  border-radius: 0.15em;
  box-sizing: border-box;
  text-decoration: none;
  font-family: 'Roboto', sans-serif;
  text-transform: uppercase;
  color: #ffffff;
  background-color: #3369ff;
  box-shadow: inset 0 -0.6em 0 -0.35em rgba(0, 0, 0, 0.17);
  text-align: center;
  position: relative;
}
</style>
