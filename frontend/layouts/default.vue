<template>
  <div>
    <nav class="navbar is-light">
      <div class="container">
        <div class="navbar-brand">
          <nuxt-link class="navbar-item" to="/">Library</nuxt-link>
          <button class="button navbar-burger">
            <span></span>
            <span></span>
            <span></span>
          </button>
        </div>
        <div class="navbar-menu">
          <div class="navbar-end">
            <nuxt-link class="navbar-item" to="/catalog">catalog</nuxt-link>
            <div class="navbar-item has-dropdown is-hoverable">
              <a class="navbar-link">My Account</a>
              <div class="navbar-dropdown">
                <nuxt-link class="navbar-item" to="/profile"></nuxt-link>
                <hr class="navbar-divider" />
                <a class="navbar-item">Logout</a>
              </div>
            </div>
            <nuxt-link class="navbar-item" to="/register">Register</nuxt-link>
            <nuxt-link v-if="!loggedIn" class="navbar-item" to="/login"
              >Log In</nuxt-link
            >
            <div v-if="loggedIn" class="navbar-item" @click="logout">
              Log out
            </div>
          </div>
        </div>
      </div>
    </nav>
    <Nuxt />
  </div>
</template>
<script>
export default {
  computed: {
    loggedIn() {
      return !!this.$store.state.JWT;
    },
  },
  mounted() {
    this.$store.dispatch('getBookMeta');
    this.$store.dispatch('getBooks');
    if (!this.$store.state.jwt) {
      this.$store.commit('setJWTtoken', localStorage.getItem('JWT'));
    }
  },
  methods: {
    logout() {
      this.$store.commit('logout');
      localStorage.removeItem('JWT');
    },
  },
};
</script>

<style lang="scss">
.navbar {
  display: flex;
  width: 100%;
  justify-content: space-between;
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: rgb(224, 224, 224);
}

[class*='navItems'] {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  float: left;
}
</style>
