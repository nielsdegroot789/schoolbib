<template>
  <div class="notify-container">
    <notificationMessage
      v-for="notification in notifications"
      :key="notification.id"
      :notification="notification"
    />
  </div>
</template>

<script>
import notificationMessage from '../components/NotificationMessage';
export default {
  name: 'Notification',
  components: {
    notificationMessage,
  },
  computed: {
    notifications() {
      return this.$store.state.notifications;
    },
  },
};
</script>

<style>
.notify-container {
  position: fixed;
  width: 300px;
  bottom: 8px;
  right: 0;
  margin-right: 15px;
  z-index: 5000;
}
</style>
