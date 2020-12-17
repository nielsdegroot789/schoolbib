<template>
  <div class="setup section">
    <DeleteUser
      :id="selectedId"
      :active="isModalActive"
      @closeModal="closeDeleteModal"
    />
    <header class="level">
      <h1 class="level-left title">Manage Users</h1>
      <nuxt-link :to="{ path: '/manage/users/new' }" class="button level-right"
        >new</nuxt-link
      >
    </header>
    <table class="table table is-bordered is-hoverable is-fullwidth">
      <thead>
        <tr style="background-color: rgb(155, 178, 221)">
          <th>Id</th>
          <th>Surname</th>
          <th>Last name</th>
          <th>email</th>
          <th>edit</th>
          <th>delete</th>
        </tr>
      </thead>
      <tfoot>
        <tr style="background-color: rgb(155, 178, 221)">
          <th>Id</th>
          <th>Surname</th>
          <th>Last name</th>
          <th>email</th>
          <th>edit</th>
          <th>delete</th>
        </tr>
      </tfoot>
      <div v-if="loadingUsers"><loading /></div>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.id }}</td>
          <td>{{ user.surname }}</td>
          <td>{{ user.lastname }}</td>
          <td>{{ user.email }}</td>
          <td>
            <nuxt-link
              :to="{ path: '/manage/users/edit/' + user.id }"
              class="button"
            >
              edit
            </nuxt-link>
          </td>
          <td>
            <button class="button" @click="setDeleteUserModal(user.id)">
              delete
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import Loading from '~/components/Loading.vue';
import DeleteUser from '~/components/DeleteUser.vue';

export default {
  components: { Loading, DeleteUser },
  data() {
    return {
      users: [],
      loadingUsers: false,
      isModalActive: false,
      selectedId: -1,
    };
  },
  computed: {},
  mounted() {
    this.loadingUsers = true;
    this.$axios
      .get('getAllUsers', {
        headers: {
          Auth: localStorage.getItem('JWT'),
        },
      })
      .then((response) => {
        this.loadingUsers = false;
        this.users = response.data;
      });
  },
  methods: {
    setDeleteUserModal(id) {
      this.selectedId = id;
      this.isModalActive = true;
    },
    closeDeleteModal() {
      this.isModalActive = false;
      this.selectedId = -1;
    },
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
