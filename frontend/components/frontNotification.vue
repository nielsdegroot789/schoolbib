<template>
  <div class="notification-container">
    <h3>{{ notification.entries[1].Notification }})</h3>
  </div>
</template>

<script>
export default {
  name: 'FrontNotification',
  computed: {
    notification() {
      return this.$store.state.notification;
    },
  },
  created() {
    this.$store.dispatch('getNotification');
  },
};
</script>
