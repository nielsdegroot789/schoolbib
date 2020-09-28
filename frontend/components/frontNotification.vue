<template>
  <div class="notification-container">
    <h3>{{ notification }}</h3>
  </div>
</template>

<script>
export default {
  name: 'FrontNotification',
  computed: {
    notification() {
      return this.$store.state.frontPageNotification;
    },
  },
  created() {
    this.$store.dispatch('getFrontPageNotification');
  },
};
</script>
