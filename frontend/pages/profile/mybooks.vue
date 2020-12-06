<template>
  <div>
    <h1>this is the list of books that you vhevked out and reserved</h1>
    <h2>My reserved Books</h2>
    <table class="table table is-bordered is-hoverable is-fullwidth">
      <thead>
        <tr>
          <th>name_book</th>
          {{
            bookname
          }}
        </tr>
      </thead>
      <tbody>
        <!-- <tr v-for="(item, index) in reservations" :key="index">
          <td>{{ item.booksName }}</td>
          <td>decline</td>
          <td class="checkoutBtn" @click="saveCheckout(item)">delete</td>
        </tr> -->
      </tbody>
    </table>
    <h2>Checkouts</h2>
    <table class="table table is-bordered is-hoverable is-fullwidth">
      <thead>
        <tr>
          <th>booksName</th>
          <th>maxAllowedDate</th>
          <th>fine</th>
          <th>DELETE</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in data" :key="index">
          <td>{{ item.booksName }}</td>
          <td>{{ item.maxAllowedDate }}</td>
          <td>{{ item.fine }}</td>
          <td class="checkoutBtn" @click="returnCheckouts(item, index) in data">
            DELETE
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
    return { bookname: '', data: '' };
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
      .get('http://localhost:8080/getCheckoutUser', {
        params: {
          data: this.UserId,
        },
      })
      .then((response) => {
        console.log(response);
        this.bookname = response.data[0].bookname;
        this.data = response.data;
      });
  },

  methods: {},
};
</script>

<style>
.checkoutBtn {
  background: red;
}
</style>
