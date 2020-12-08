<template>
  <div class="setup section">
    <header class="level">
      <h1 class="level-left title">
        Wishlits. this could be a carousel with books that are you favorite.
      </h1>
    </header>
    <tbody>
      <tr v-for="(item, index) in dataFavBook" :key="index">
        <td>{{ item.title }}</td>
        <td>{{ item.isbnCode }}</td>
        <td>{{ item.totalPages }}</td>
        <td>{{ item.rating }}</td>
        <td><img :src="item.sticker" alt="Book cover image" /></td>
        <td></td>
        <td><button @onclick="deleteFunction()">Delete</button></td>
      </tr>
    </tbody>

    <thead>
      <tr>
        <th>Authors U like</th>
        <th class="deleteButton">delete</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(item, index) in dataFavAuthor" :key="index">
        <td>{{ item.name }}</td>
        <td><button @onclick="deleteFunction()">Delete</button></td>
      </tr>
    </tbody>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  data() {
    return {
      dataFavAuthor: '',
      dataFavBook: '',
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

  created() {
    console.log(this.UserId);

    axios
      .get('http://localhost:8080/getFavoriteAuthors', {
        params: {
          data: this.UserId,
          headers: {
            Auth: this.$store.state.JWT,
          },
        },
      })
      .then((response) => {
        console.log(response);
        this.dataFavAuthor = response.data;
      });
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
        console.log(response);
        this.dataFavBook = response.data;
      });
  },
};
</script>

<style>
.deleteButton {
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
