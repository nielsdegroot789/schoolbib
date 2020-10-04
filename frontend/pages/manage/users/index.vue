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
        <span>Accept</span>
      </div>
      <nuxt-link
        v-for="(item, index) in reservations"
        :key="index"
        to="/manage/users"
        class="usersContainer"
      >
        <span>{{ item.usersId }}</span>
        <span>{{ item.usersName }}</span>
        <span>{{ item.booksId }}</span>
        <span>{{ item.booksName }}</span>
        <span>{{ item.reservationDateTime }}</span>
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
      this.axios
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
