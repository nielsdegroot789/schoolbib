<template>
  <div id="profile-page-container">
    <div class="profile-navigation-container">
      <dashboard />
    </div>
    <div class="main-profile-container"><NuxtChild /></div>
  </div>
</template>

<script>
import dashboard from '../components/Dashboard';
export default {
  components: { dashboard },
};
</script>
