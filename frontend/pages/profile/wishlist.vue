<template>
  <div class="setup section">
    <header class="level">
      <h1 class="level-left title">
        Wishlits. this could be a carousel with books that are you favorite.
      </h1>
    </header>
    <thead>
      <tr>
        <th>book Title</th>
        <th>isbn</th>
        <th>total pages</th>
        <th>rating</th>
        <th>sticker</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="book in bookMeta" :key="book.id">
        <td>{{ book.title }}</td>
        <td>{{ book.isbnCode }}</td>
        <td>{{ book.totalPages }}</td>
        <td>{{ book.rating }}</td>
        <td><img :src="book.sticker" alt="Book cover image" /></td>
        <td></td>
        <td><button @onclick="deleteFunction()">Delete</button></td>
      </tr>
    </tbody>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  data() {
    return {};
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
      .get('http://localhost:8080/getFavoriteBooks', {
        params: {
          data: this.UserId,
        },
      })
      .then((response) =>
        (this.formValues.firstName = response.data[0].surname)(
          (this.formValues.lastName = response.data[0].lastname),
          (this.formValues.email = response.data[0].email),
        ),
      );
  },

  methods: {},
};
</script>

<style></style>
