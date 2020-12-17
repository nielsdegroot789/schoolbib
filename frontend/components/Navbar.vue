<template>
  <header class="nav">
    <div class="nav__logo">
      <div class="nav__nav-item">
        <nuxt-link class="nuxt-link-active" to="/">home</nuxt-link>
      </div>
    </div>
    <div>
      <nav class="nav__nav">
        <div class="nav__nav-item books">
          <nuxt-link class="nuxt-link-active" to="/books?page=1"
            >Books</nuxt-link
          >
        </div>

        <div
          v-if="loggedIn && (currentRole == 3 || currentRole == 2)"
          class="nav__nav-item manage"
        >
          <nuxt-link class="nuxt-link-active" to="/manage/books"
            >Manage books</nuxt-link
          >
        </div>

        <div
          v-if="loggedIn && (currentRole == 3 || currentRole == 2)"
          class="nav__nav-item manage"
        >
          <nuxt-link class="nuxt-link-active" to="/manage/users"
            >Manage users</nuxt-link
          >
        </div>

        <div
          v-if="loggedIn && (currentRole == 3 || currentRole == 2)"
          class="nav__nav-item manage"
        >
          <nuxt-link to="/manage/reservations" class="nuxt-link-active">
            Manage reservations
          </nuxt-link>
        </div>
        <div
          v-if="loggedIn && (currentRole == 2 || currentRole == 3)"
          class="nav__nav-item nav__nav-item--has-submenu manageOverlay"
        >
          <a class="nuxt-link-active"> Manage </a>
          <div class="nav__nav-sub">
            <div v class="nav__nav-item">
              <nuxt-link class="nuxt-link-active" to="/manage/books"
                >Manage books</nuxt-link
              >
            </div>
            <div class="nav__nav-item">
              <nuxt-link class="nuxt-link-active" to="/manage/users"
                >Manage users</nuxt-link
              >
            </div>
            <div class="nav__nav-item">
              <nuxt-link to="/manage/reservations" class="nuxt-link-active">
                Manage reservations
              </nuxt-link>
            </div>
          </div>
        </div>
        <div
          v-if="
            loggedIn &&
            (currentRole == 1 || currentRole == 2 || currentRole == 3)
          "
          class="nav__nav-item nav__nav-item--has-submenu"
        >
          <a class="nuxt-link-active"> Profile </a>
          <div class="nav__nav-sub">
            <div class="nav__nav-item">
              <nuxt-link v-if="loggedIn" to="/profile">Information </nuxt-link>
            </div>
            <div class="nav__nav-item">
              <nuxt-link v-if="loggedIn" to="/profile/mybooks"
                >My books</nuxt-link
              >
            </div>
            <div class="nav__nav-item">
              <nuxt-link v-if="loggedIn" to="/profile/wishlist"
                >wishlist</nuxt-link
              >
            </div>

            <div v-if="loggedIn" class="nav__nav-item">
              <div v-if="loggedIn" class="navbar-item" @click="logout">
                Log out
              </div>
            </div>
          </div>
        </div>
        <div v-if="!loggedIn" class="nav__nav-item">
          <nuxt-link class="navbar-item nuxtLinkA" to="/login">
            Log In
          </nuxt-link>
        </div>
      </nav>
    </div>
  </header>
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
  methods: {
    logout() {
      this.$store.commit('logout');
      this.$store.commit('logout');
      localStorage.removeItem('JWT');
    },
  },
};
</script>
<style>
.nav {
  width: 100%;
  display: flex;
  position: relative;
  justify-content: space-between;
  z-index: 1;
  box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
}
.nav__nav {
  position: relative;
  display: flex;
}

.nav__nav-sub {
  transform-origin: top;
  transform: scaleY(0);
  position: absolute;
  top: 100%;
  background-color: #fff;
  box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
  transition: transform 100ms ease-in-out;
}
.nav__nav-item {
  transition: background-color 200ms linear;
}
.nav__nav-item > a,
.nav__nav-item .nuxtLinkA {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  height: 5rem;
  box-sizing: border-box;
  padding: 1rem 2rem;
  font-size: 1.2rem;
  color: #464646;
  font-weight: bold;
  transition: color 200ms linear;
}
.nav__nav-item--has-submenu > a,
.nav__nav-item--has-submenu .nuxtLinkA {
  padding-right: 4rem;
}
.nav__nav-item--has-submenu > a:after,
.nav__nav-item--has-submenu .nuxtLinkA:after {
  display: block;
  content: '';
  height: 0;
  width: 0;
  position: absolute;
  right: 1.5rem;
  top: 50%;
  margin-top: -0.5rem;
  border-left: 0.65rem solid transparent;
  border-right: 0.65rem solid transparent;
  border-top: 1rem solid #464646;
  transition: border-top-color 400ms linear, transform 200ms ease-in-out;
}
.nav__nav-item:last-child .nav__nav-sub {
  right: 0;
}
.nav__nav-item--active,
.nav__nav-item:hover {
  background-color: rgb(104, 147, 228);
}
.nav__nav-item--active > a,
.nav__nav-item:hover > a,
.nav__nav-item--active .nuxtLinkA,
.nav__nav-item:hover .nuxtLinkA {
  color: #fff;
}
.nav__nav-item--active > a:after,
.nav__nav-item:hover > a:after,
.nav__nav-item--active .nuxtLinkA:after,
.nav__nav-item:hover .nuxtLinkA:after {
  border-top-color: #fff;
  transform: rotate(180deg);
}
.nav__nav-item:hover .nav__nav-sub {
  transform: scaleY(1);
}
.manageOverlay {
  display: none;
}
@media only screen and (max-width: 1200px) {
  .manageOverlay {
    display: block;
  }
  .manage {
    display: none;
  }
}
@media only screen and (max-width: 600px) {
  .manageOverlay {
    display: none;
  }
  .books {
    display: none;
  }
}
</style>
