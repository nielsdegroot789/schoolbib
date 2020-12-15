<template>
  <div class="setup section">
    <header class="level">
      <h1 class="level-left title">Manage Reservations</h1>
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
      <div v-if="loadingReservation"><Loading /></div>
      <tbody v-if="!loadingReservation">
        <tr v-for="(item, index) in reservations" :key="index">
          <td>{{ item.usersId }}</td>
          <td>{{ item.usersName }}</td>
          <td>{{ item.booksId }}</td>
          <td>{{ item.booksName }}</td>
          <td>{{ item.reservationDateTime }}</td>
          <td>
            <button class="button" @click="saveCheckout(item)">Accept!</button>
          </td>
        </tr>
      </tbody>
    </table>
    <nuxt-link
      :to="{ path: '/manage/reservations/new' }"
      class="button level-right"
      >new</nuxt-link
    >
    <h2>Checkouts</h2>

    <table class="table table is-bordered is-hoverable is-fullwidth">
      <thead>
        <tr>
          <th>userName</th>
          <th>book</th>
          <th>checkoutDateTime</th>
          <th>maxAllowedDate</th>
          <th>fine</th>
          <th>return</th>
        </tr>
      </thead>
      <div v-if="loadingCheckouts"><Loading /></div>
      <tbody v-if="!loadingCheckouts">
        <tr v-for="(item, index) in checkouts" :key="index">
          <td>{{ item.usersName }}</td>
          <td>{{ item.booksName }}</td>
          <td>{{ item.checkoutDateTime }}</td>
          <td>{{ item.maxAllowedDate }}</td>
          <td>{{ item.fine }}</td>
          <td>
            <button
              class="button"
              @click="returnCheckouts(item, index) in checkouts"
            >
              Paid and returned
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import Loading from '~/components/Loading';
export default {
  components: { Loading },
  data() {
    return {
      loadingReservation: false,
      loadingCheckouts: false,
      reservations: '',
      checkouts: '',
      fine: '',
    };
  },
  computed: {},

  created() {
    this.loadReservations();
    this.loadCheckouts();
  },

  methods: {
    loadReservations() {
      this.loadingReservation = true;
      this.$axios
        .get('http://localhost:8080/getReservations', {
          headers: {
            Auth: localStorage.getItem('JWT'),
          },
        })
        .then((response) => {
          this.loadingReservation = false;
          this.reservations = response.data;
        });
    },
    loadCheckouts() {
      this.loadingCheckouts = true;
      this.$axios
        .get('http://localhost:8080/getCheckouts', {
          headers: {
            Auth: localStorage.getItem('JWT'),
          },
        })
        .then((response) => {
          this.loadingCheckouts = false;
          this.checkouts = response.data;
        });
    },
    addDays(date, days) {
      const result = new Date(date);
      result.setDate(result.getDate() + days);
      return result;
    },
    saveCheckout(object) {
      const today = new Date();
      const inTwoWeeks = this.addDays(today, 14);
      const checkoutDateTime = today.toLocaleString('en-GB');
      const maxAllowedDate = inTwoWeeks.toLocaleString('en-GB');

      this.$axios
        .post('http://localhost:8080/saveCheckouts', {
          headers: { Auth: localStorage.getItem('JWT') },
          usersId: object.usersId,
          booksId: object.booksId,
          checkoutDateTime,
          maxAllowedDate,
        })
        .then((response) => {
          this.loadCheckouts();
          this.loadReservations();
        });
    },
    returnCheckouts(object) {
      const today = new Date();
      const returnDateTime = today.toLocaleString('en-GB');

      this.$axios
        .post('http://localhost:8080/returnCheckouts', {
          returnDateTime,
        })
        .then((response) => {
          this.loadCheckouts();
          this.loadReservations();
        });
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
