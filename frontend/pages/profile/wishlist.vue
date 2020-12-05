<template>
  <div class="setup section">
    <header class="level">
      <h1 class="level-left title">
        Wishlits. this could be a carousel with books that are you favorite.
      </h1>
    </header>
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },
  computed: {},

  created() {
    this.$axios.get('http://localhost:8080/getWishlist').then((response) => {
      this.reservations = response.data;
    });
    this.$axios.get('http://localhost:8080/getCheckouts').then((response) => {
      this.checkouts = response.data;
    });
  },

  methods: {},
};
</script>

<style></style>
