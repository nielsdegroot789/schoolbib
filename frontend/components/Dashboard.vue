<template>
  <div>
    <div class="dashboard-link">
      <font-awesome-icon :icon="['fas', 'info-circle']" class="fa-icon" />
      <nuxt-link to="/profile">Information</nuxt-link>
    </div>
    <div class="dashboard-link">
      <font-awesome-icon :icon="['fas', 'book']" class="fa-icon" />
      <nuxt-link to="/profile/mybooks">My books</nuxt-link>
    </div>
    <div class="dashboard-link">
      <font-awesome-icon :icon="['fas', 'heart']" class="fa-icon" />
      <nuxt-link to="/profile/wishlist">My wishlist</nuxt-link>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Dashboard',
};
</script>

<style></style>
