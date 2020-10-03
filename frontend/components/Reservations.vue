<template>
  <div class="setup">
    <h1 class="crudHeader crudTitle">Manage Users</h1>
    <div>
      <div class="titleColumn">
        <span>id_user</span>
        <span>name_user</span>
        <span>id_book</span>
        <span>name_book</span>
        <span>reservation date</span>
        <span>accepted</span>
      </div>
      <nuxt-link
        v-for="(item, index) in reservations"
        :key="index"
        class="usersContainer"
      >
        <span>{{ reservations.usersId }}</span>
        <span>{{ items.name }}</span>
        <span>{{ reservations }}</span>
        <span>{{ item.reservationDate }}</span>
        <span>{{ item.accepted }}</span>

        <Button
          class="checkoutBtn"
          @click="
            saveCheckout();
            saveCheckoutNotif();
          "
        >
          Reserve Now!
        </Button>
      </nuxt-link>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  name: 'Reservations',
  data() {
    return {};
  },
  computed: {
    reservations() {
      return this.$store.state.reservations;
    },
  },
  created() {
    setInterval(this.getToday, 10000);
  },

  methods: {
    saveCheckout() {
      axios
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
  grid-template-columns: repeat(7, calc(90% / 7)) 5% 5%;
  justify-items: center;
  align-items: center;
  margin: 5px 0;
  font-weight: bold;
}
.usersContainer {
  display: grid;
  grid-template-columns: repeat(7, calc(90% / 7)) 5% 5%;
  justify-items: center;
  align-items: center;
  margin: 5px 0;
}
</style>
