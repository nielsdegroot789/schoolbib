<template>
  <div>
    <h1>RESERVATIONS</h1>
    <table class="table table is-bordered is-hoverable is-fullwidth">
      <thead>
        <tr>
          <th>name_book</th>
          <th>delete</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in dataRes" :key="index">
          <td>{{ item.booksName }}</td>
          <td class="checkoutBtn" @click="saveCheckout(item, index) in dataRes">
            delete
          </td>
        </tr>
      </tbody>
    </table>
    <h1>CHECKOUTS</h1>
    <table class="table table is-bordered is-hoverable is-fullwidth">
      <thead>
        <tr>
          <th>booksName</th>
          <th>maxAllowedDate</th>
          <th>fine</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in dataCheck" :key="index">
          <td>{{ item.booksName }}</td>
          <td>{{ item.maxAllowedDate }}</td>
          <td>{{ item.fine }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  data() {
    return {
      dataCheck: '',
      dataRes: '',
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
      .get('http://localhost:8080/getCheckoutUser', {
        params: {
          data: this.UserId,
        },
      })
      .then((response) => {
        console.log(response);
        this.dataCheck = response.data;
      });
    axios
      .get('http://localhost:8080/getReservationUser', {
        params: {
          data: this.UserId,
        },
      })
      .then((response) => {
        console.log(response);
        this.dataRes = response.data;
      });
  },

  methods: {},
};
</script>

<style scoped>
.checkoutBtn {
  background: red;
}
</style>
