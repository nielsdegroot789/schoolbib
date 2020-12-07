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
    // todo create system that only loads this one for the first time until new notif is made
    this.$axios
      .get('http://localhost:8080/getNotification')
      .then((response) => {
        this.frontpageNotif = response.data;
        this.showNotif = true;
      });
  },
  methods: {
    hideNotification() {
      this.showNotif = false;
      const coocckie = Vue.coockie.get('showNotif');
      console.log(coocckie);
    },
  },
};
</script>

<style>
.center-link-frontpage {
  text-align: center;
}
</style>
