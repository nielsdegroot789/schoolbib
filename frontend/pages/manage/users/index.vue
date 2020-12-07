<template>
  <div class="setup section">This is page for managing the actual users</div>
</template>

<script>
export default {
  created() {
    this.$axios
      .get('http://localhost:8080/getReservations', {
        headers: { Auth: localStorage.getItem('JWT') },
      })
      .then((response) => {
        this.reservations = response.data;
      });
    this.$axios
      .get('http://localhost:8080/getCheckouts', {
        headers: { Auth: localStorage.getItem('JWT') },
      })
      .then((response) => {
        this.checkouts = response.data;
      });
  },

  methods: {
    checkNow() {
      const today = new Date();
      const date =
        today.getFullYear() +
        '-' +
        (today.getMonth() + 1) +
        '-' +
        today.getDate();
      const time =
        today.getHours() + ':' + today.getMinutes() + ':' + today.getSeconds();
      const dateTime = date + ' ' + time;
      this.DateNow = dateTime.toString();
    },

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
      this.fine = 0;
      this.$axios
        .post('http://localhost:8080/returnCheckouts', {
          returnDateTime: object.returnDateTime,
        })
        .then(function (response) {});
    },
  },
};
</script>

<style></style>
