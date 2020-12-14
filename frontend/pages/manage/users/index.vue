<template>
  <div class="setup section">
    <header class="level">
      <h1 class="level-left title">Manage Users</h1>
      <nuxt-link :to="{ path: '/manage/users/new' }" class="button level-right"
        >new</nuxt-link
      >
    </header>
    <table class="table table is-bordered is-hoverable is-fullwidth">
      <thead>
        <tr>
          <th>Id</th>
          <th>Surname</th>
          <th>Last name</th>
          <th>age</th>
          <th>email</th>
          <th>send password reset</th>
          <th>edit</th>
          <th>delete</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th>Id</th>
          <th>Surname</th>
          <th>Last name</th>
          <th>age</th>
          <th>email</th>
          <th>send password reset</th>
          <th>edit</th>
          <th>delete</th>
        </tr>
      </tfoot>
      <tbody>
        <tr v-for="book in bookMeta" :key="book.id">
          <td>{{ book.id }}</td>
          <td>{{ book.surname }}</td>
          <td>{{ book.lastname }}</td>
          <td>{{ book.age }}</td>
          <td>{{ book.email }}</td>
          <td>
            <button class="button">send PW reset</button>
          </td>
          <td>
            <nuxt-link
              :to="{ path: '/manage/users/edit/' + book.id }"
              class="button"
            >
              edit
            </nuxt-link>
          </td>
          <td>
            <button class="button">delete</button>
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
      users: [],
    };
  },
  computed: {},
  mounted() {
    this.$axios
      .get('http://localhost:8080/getUsers', {
        headers: { Auth: this.$store.JWT },
      })
      .then((response) => {
        this.users = response.data;
      });
  },
};
</script>

<style>
.setup {
  margin: 0 5%;
  box-sizing: border-box;
  height: 100%;
  overflow-x: auto;
}

.links {
  padding-top: 15px;
}

.booksContainer:nth-child(odd) {
  background-color: lightgray;
}

.headerContainer {
  display: grid;
  grid-template-columns: repeat(11, calc(90% / 11)) 5% 5%;
  justify-items: center;
  align-items: center;
  margin: 5px 0;
  font-weight: bold;
}

.booksContainer {
  display: grid;
  grid-template-columns: repeat(11, calc(90% / 11)) 5% 5%;
  justify-items: center;
  align-items: center;
  margin: 5px 0;
}
</style>
