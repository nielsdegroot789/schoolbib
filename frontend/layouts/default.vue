<template>
  <div class="defaultLayout">
    <Notification />
    <div class="main">
      <Navbar />
      <Nuxt />
    </div>
    <Footer />
  </div>
</template>
<script>
import Notification from '~/components/Notification';
import Footer from '~/components/Footer';
import Navbar from '~/components/Navbar';

export default {
  components: {
    Notification,
    Footer,
    Navbar,
  },
  mounted() {
    this.$store.dispatch('getBookMeta');
    this.$store.dispatch('getBooks');
    if (!this.$store.state.jwt) {
      if (localStorage.getItem('JWT')) {
        this.$store.commit('setJWTtoken', localStorage.getItem('JWT'));
      }
    }
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

.defaultLayout {
  display: flex;
  flex-direction: column;
}

.main {
  min-height: 100vh;

  flex-grow: 1;
}
</style>
