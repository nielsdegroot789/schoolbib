<template>
  <nav class="navbar is-light">
    <div class="container">
      <div class="navbar-brand">
        <nuxt-link class="navbar-item" to="/">Home</nuxt-link>
      </div>
      <div class="navbar-menu">
        <div class="navbar-end">
          <nuxt-link
            v-if="loggedIn && (currentRole == 3 || currentRole == 2)"
            class="navbar-item"
            to="/manage/books"
          ></nuxt-link>

          <div
            v-if="loggedIn && currentRole == 1"
            id="dropdownMenu"
            class="dropdownProfile"
          >
            <button class="dropbtn" @click="visible = !visible">profile</button>
            <div v-if="visible" id="myDropdown" class="dropdown-content">
              <a class="sub-item" @click="visible = !visible">
                <nuxt-link v-if="loggedIn" class="navbar-item" to="/profile"
                  >Information</nuxt-link
                >
              </a>
              <a class="sub-item" @click="visible = !visible">
                <nuxt-link
                  v-if="loggedIn"
                  class="navbar-item"
                  to="/profile/mybooks"
                  >My books</nuxt-link
                >
              </a>
              <a class="sub-item" @click="visible = !visible">
                <nuxt-link
                  v-if="loggedIn"
                  class="navbar-item"
                  to="/profile/wishlist"
                  >wishlist</nuxt-link
                >
              </a>
            </div>
          </div>
          <nuxt-link
            v-if="loggedIn"
            class="navbar-item"
            to="/manage/books"
            profile-clear
            >Manage books</nuxt-link
          >
          <nuxt-link
            v-if="loggedIn && (currentRole == 3 || currentRole == 2)"
            class="navbar-item"
            to="/manage/users"
            >Manage users</nuxt-link
          >
          <nuxt-link
            v-if="loggedIn && (currentRole == 3 || currentRole == 2)"
            class="navbar-item"
            to="/manage/reservations"
            >Manage reservations</nuxt-link
          >
          <nuxt-link class="navbar-item" to="/books?page=1">Books</nuxt-link>
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
  data() {
    return {
      visible: false,
    };
  },
  computed: {
    currentRole() {
      return +this.$store.state.currentUser.role;
    },
    loggedIn() {
      return !!this.$store.state.JWT;
    },
  },
  mounted() {
    document.addEventListener('click', this.documentClick);
  },
  methods: {
    logout() {
      this.$store.commit('logout');
      this.$store.commit('logout');
      localStorage.removeItem('JWT');
    },
    dropDownFunction() {
      document.getElementById('myDropdown').classList.toggle('show');
    },

    documentClick(e) {
      const el = document.getElementById('dropdownMenu');
      const target = e.target;
      if (el !== target && !el.contains(target)) {
        this.visible = false;
      }
    },
  },
};
</script>

<style>
.dropbtn {
  padding: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

.dropdownProfile {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  position: fixed;
  background-color: #f1f1f1;
  min-width: 160px;
  overflow: auto;
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.show {
  display: block;
}
</style>
