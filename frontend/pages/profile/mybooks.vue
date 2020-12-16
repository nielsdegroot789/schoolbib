<template>
  <div>
    <table class="table table is-bordered is-hoverable is-fullwidth aboveBlock">
      <thead>
        <tr>
          <th>Reservations</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in dataRes" :key="index">
          <td class="itemBlock">
            <div class="FiftyWidth">{{ item.booksName }}</div>
            <div class="FiftyWidth">
              <p class="checkoutBtn" @click.stop="deleteRes(item.id)">delete</p>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <table
      class="table table is-bordered is-hoverable is-fullwidth beneethBlock"
    >
      <thead>
        <tr>
          <th>booksName</th>
          <th>maxAllowedDate</th>
          <th>fine</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="data in dataCheck" :key="data.id">
          <td>{{ data.booksName }}</td>
          <td>{{ data.maxAllowedDate }}</td>
          <td>{{ data.fine }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      dataCheck: [],
      dataRes: [],
    };
  },
  computed: {
    UserId() {
      return this.$store.state.currentUser.id;
    },
    JWT() {
      return this.$store.state.JWT;
    },
  },

  mounted() {
    this.$axios
      .get('getCheckoutUser', {
        headers: { Auth: localStorage.getItem('JWT') },
        params: {
          id: this.UserId,
        },
      })
      .then((response) => {
        console.log(response.data);
        this.dataCheck = response.data;
      });

    this.$axios
      .get('getReservationUser', {
        headers: { Auth: localStorage.getItem('JWT') },
        params: {
          id: this.UserId,
        },
      })
      .then((response) => {
        console.log(response);
        this.dataRes = response;
      });
  },

  methods: {
    deleteRes(id) {
      console.log(id);
      this.$axios
        .delete('deleteReservationUser', {
          headers: { Auth: localStorage.getItem('JWT') },
          params: {
            id: this.UserId,
          },
        })
        .then((response) => {
          console.log(response);
          this.refreshBooks();
        });
    },
    refreshBooks() {
      this.$axios
        .get('getReservationUser', {
          headers: { Auth: localStorage.getItem('JWT') },
          params: {
            id: this.UserId,
          },
        })
        .then((response) => {
          console.log(response);
          this.dataRes = response.data;
        });
    },
  },
};
</script>

<style scoped>
.checkoutBtn {
  display: inline-block;
  padding: 0.7em 1.4em;
  margin: 0 0.3em 0.3em 0;
  border-radius: 0.15em;
  box-sizing: border-box;
  text-decoration: none;
  font-family: 'Roboto', sans-serif;
  text-transform: uppercase;
  color: #ffffff;
  background-color: #3369ff;
  box-shadow: inset 0 -0.6em 0 -0.35em rgba(0, 0, 0, 0.17);
  text-align: center;
  position: relative;
}
.checkoutBtn:active {
  margin-top: 0.1em;
}
.itemBlock {
  display: flex;
  justify-content: space-around;
}

.aboveBlock {
  width: 75%;
  margin: 20px auto;
}

.beneethBlock {
  width: 75%;
  margin: 20px auto;
}
.FiftyWidth {
  display: flex;
  width: 100%;
  justify-content: center;
}
</style>
