<template>
  <nav class="navbar is-light">
    <div class="container">
      <div class="navbar-brand">
        <nuxt-link class="navbar-item" to="/">Home</nuxt-link>
      </div>
      <div class="navbar-menu">
        <div class="navbar-end">
          <nuxt-link v-if="loggedIn" class="navbar-item" to="/manage/books"
            >Manage books</nuxt-link
          >
          <nuxt-link v-if="loggedIn" class="navbar-item" to="/manage/users"
            >Manage users</nuxt-link
          >
          <nuxt-link class="navbar-item" to="/books">Books</nuxt-link>
          <nuxt-link v-if="!loggedIn" class="navbar-item" to="/login"
            >Log In</nuxt-link
          >
          <div v-if="loggedIn" class="navbar-item" @click="logout">Log out</div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  methods: {
    logout() {
      this.$store.commit('logout');
      localStorage.removeItem('JWT');
    },
  },
};
</script>

<style></style>
