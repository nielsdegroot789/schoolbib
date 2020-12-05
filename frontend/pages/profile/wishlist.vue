<template>
  <div class="setup section">
    <header class="level">
      <h1 class="level-left title">
        this is the wishlist. of books you have added as favorite
      </h1>
    </header>
    <h2>Reservations</h2>
    <table class="table table is-bordered is-hoverable is-fullwidth">
      <thead>
        <tr>
          <th>id_user</th>
          <th>name_user</th>
          <th>id_book</th>
          <th>name_book</th>
          <th>reservation date</th>
          <th>Accept</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in reservations" :key="index">
          <td>{{ item.usersId }}</td>
          <td>{{ item.usersName }}</td>
          <td>{{ item.booksId }}</td>
          <td>{{ item.booksName }}</td>
          <td>{{ item.reservationDateTime }}</td>
          <td class="checkoutBtn" @click="saveCheckout(item)">Accept!</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      reservations: '',
      checkouts: '',
      fine: '',
      isEditing: false,
      DateNow: '',
    };
  },
  computed: {},

  created() {
    this.$axios.get('http://localhost:8080/getWishlist').then((response) => {
      this.reservations = response.data;
    });
    this.$axios.get('http://localhost:8080/getCheckouts').then((response) => {
      this.checkouts = response.data;
    });
  },

  methods: {},
};
</script>

<style></style>
