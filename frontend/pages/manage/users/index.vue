<template>
  <div class="setup section">
    <header class="level">
      <h1 class="level-left title">Manage Users</h1>
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

    <h2>Checkouts</h2>
    <table class="table table is-bordered is-hoverable is-fullwidth">
      <thead>
        <tr>
          <th>userName</th>
          <th>book</th>
          <th>checkoutDateTime</th>
          <th>maxAllowedDate</th>
          <th>fine</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in checkouts" :key="index">
          <td>{{ item.usersName }}</td>
          <td>{{ item.booksName }}</td>
          <td>{{ item.checkoutDateTime }}</td>
          <td>{{ item.maxAllowedDate }}</td>
          <td>
            <p v-if="!isEditing">{{ item.fine }}</p>
            <input v-else type="text" />
            <button class="changeFine" @click="EditMsg(item, index)">
              Change
            </button>
          </td>
          <td
            class="checkoutBtn"
            @click="returnCheckouts(item, index) in checkouts"
          >
            Returned!
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
      checkouts: '',
      fine: '',
      isEditing: false,
    };
  },
  computed: {},

  created() {
    this.$axios
      .get('http://localhost:8080/getReservations')
      .then((response) => {
        this.reservations = response.data;
      });
    this.$axios.get('http://localhost:8080/getCheckouts').then((response) => {
      this.checkouts = response.data;
    });
  },

  methods: {
    EditMsg(object) {
      this.isEditing = true;
    },
    saveCheckout(object) {
      const today = new Date();
      const date =
        today.getFullYear() +
        '-' +
        (today.getMonth() + 1) +
        '-' +
        today.getDate();
      this.checkoutDateTime = date.toString();

      const inTwoWeeks = new Date();
      const dateInTwoWeeks =
        inTwoWeeks.getFullYear() +
        '-' +
        (inTwoWeeks.getMonth() + 1) +
        '-' +
        (inTwoWeeks.getDate() + 14);
      this.maxAllowedDate = dateInTwoWeeks.toString();
      this.$axios
        .post('http://localhost:8080/saveCheckouts', {
          usersId: object.usersId,
          booksId: object.booksId,
          checkoutDateTime: this.checkoutDateTime,
          returnDateTime: '',
          maxAllowedDate: this.maxAllowedDate,
          fine: 0,
          isPaid: '',
        })
        .then(function (response) {});
    },

    returnCheckouts(object) {
      const today = new Date();
      const date =
        today.getFullYear() +
        '-' +
        (today.getMonth() + 1) +
        '-' +
        today.getDate();
      this.returnDateTime = date.toString();
      this.$axios
        .update('http://localhost:8080/returnCheckouts', {
          returnDateTime: object.returnDateTime,
        })
        .then(function (response) {
          // this.$store.dispatch('addNotification', {
          //   type: 'success',
          //   message: 'Form saved',
          // });
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
