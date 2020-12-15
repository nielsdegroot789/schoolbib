<template>
  <div class="index">
    <searchBar />

    <div class="intro-text-container">
      <div class="intro-text"><h2>Let's get started</h2></div>
    </div>

    <div v-if="showNotif" class="frontpageNotif">
      <div>
        {{ frontpageNotif }}
        <button class="button is-small" type="button" @click="hideNotification">
          X
        </button>
      </div>
    </div>

    <div class="quick-links-container">
      <ul>
        <li>
          <a
            href="#footer"
            :class="['quick-link', { 'center-link-frontpage': !JWT }]"
            >Opening hours</a
          >
        </li>
        <li v-if="JWT">
          <nuxt-link to="/profile" class="quick-link">My profile</nuxt-link>
        </li>
      </ul>
    </div>

    <Carousel />
  </div>
</template>

<script>
import searchBar from '../components/SearchBar';
import Carousel from '../components/Carousel';

export default {
  components: {
    searchBar,
    Carousel,
  },
  data() {
    return {
      frontpageNotif: '',
      showNotif: false,
    };
  },
  computed: {
    JWT() {
      return this.$store.state.JWT;
    },
  },
  created() {
    this.$axios.get('getNotification').then((response) => {
      this.frontpageNotif = response.data;
      if (this.$cookies.get('shownotif') === false) {
        this.showNotif = false;
      } else {
        this.showNotif = true;
      }
    });
  },
  methods: {
    hideNotification() {
      this.showNotif = false;
      this.$cookies.set('shownotif', 'false', {
        path: '/',
        maxAge: 60 * 60 * 24 * 7,
      });
    },
  },
};
</script>

<style>
.center-link-frontpage {
  text-align: center;
}
</style>
