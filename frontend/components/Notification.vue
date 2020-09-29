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
  methods: {
    deleteNotification() {
      this.$store.dispatch('deleteNotification');
    },
  },
};
</script>

<style>
.notify-container {
  position: fixed;
  width: 360px;
  bottom: 0;
  right: 0;
  margin-right: 15px;
  z-index: 5000;
}
</style>
