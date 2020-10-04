<template>
  <div class="setup section">
    <header class="level">
      <h1 class="level-left title">Manage Users</h1>
    </header>
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
          <td
            class="checkoutBtn"
            @click="
              saveCheckout();
              saveCheckoutNotif();
            "
          >
            Reserve Now!
          </td>
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
    };
  },
  computed: {},

  created() {
    this.$axios
      .get('http://localhost:8080/getReservations')
      .then((response) => {
        this.reservations = response.data;
      });
    setInterval(this.getToday, 10000);
  },

  methods: {
    saveCheckout() {
      this.$axios
        .post('http://localhost:8080/saveCheckouts', {
          booksId: this.$route.params.book,
          usersId: this.currentUserId,
          checkoutDateTime: this.timestamp,
        })
        .then(function (response) {});
    },
    saveCheckoutNotif() {
      this.$store.dispatch('addNotification', {
        type: 'success',
        message: 'Form saved',
      });
    },
    getToday() {
      const today = new Date();
      const date =
        today.getFullYear() +
        '-' +
        (today.getMonth() + 1) +
        '-' +
        today.getDate();
      this.timestamp = date.toString();
    },
  },
};
</script>

<style>
.titleColumn {
  display: grid;
  grid-template-columns: repeat(7, calc(90% / 7));
  justify-items: center;
  align-items: center;
  margin: 5px 0;
  font-weight: bold;
}
.usersContainer {
  display: grid;
  grid-template-columns: repeat(7, calc(90% / 7));
  justify-items: center;
  align-items: center;
  margin: 5px 0;
}
</style>
