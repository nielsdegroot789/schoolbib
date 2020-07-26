<template>
  <v-app-bar class="navbar" color="green">
    <div class="navItemBox">
      <router-link class="navItems" text to="/">HomePage</router-link>
      <router-link class="navItems" text to="/library">Library</router-link>
    </div>
    <div class="floatRight">
      <div v-if="$auth.loggedIn">
        <router-link class="navItemsFloatRight" text> logout</router-link>

        <!-- Username -->
        <!-- logout button -->
        <!-- {{ $auth.user.mail }},        
              {{ $auth.user.adress }},
              {{ $auth.user.age }},
              {{ $auth.user.surname }} & {{ $auth.user.lastname }} -->
      </div>
      <div v-else>
        <router-link class="navItemsFloatRight" text to="/signup"
          >Login</router-link
        >
        <router-link class="navItemsFloatRight" text to="/signup"
          >register</router-link
        >

        <!-- Login -->
        <!-- logout -->
      </div>
    </div>
  </v-app-bar>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped>
.navbar {
  display: flex;
  width: 100%;
  justify-content: space-between;
}
.navbar {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
}

[class*='navItems'] {
  float: left;
}

[class*='navItems'] {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

[class*='navItems']s:hover {
  background-color: #111;
}
.floatRight {
  float: right;
}
</style>
