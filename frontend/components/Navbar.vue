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
  computed: {
    isStudent() {
      return this.$store.state.isStudent;
    },
    isAdmin() {
      return this.$store.state.isAdmin;
    },
    currentRole() {
      return this.$store.state.currentUser.role;
    },
    loggedIn() {
      return !!this.$store.state.JWT;
    },
  },
  methods: {
    WhatUserIsLoggedIn() {
      switch (this.currentRole) {
        case 1:
          this.isStudent === true;
          break;
        case 2:
          this.isAdmin === true;
          break;
      }
      return false;
    },
    logout() {
      this.$store.commit('logout');
      localStorage.removeItem('JWT');
    },
  },
};
</script>

<style></style>
