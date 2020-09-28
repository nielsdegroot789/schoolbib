<template>
  <div :class="typeClass" class="notification-message-container">
    <button class="close-button" @click="deleteNotification()">
      <font-awesome-icon :icon="['fa', 'times']" />
    </button>
    <p>{{ notification.message }}</p>
  </div>
</template>

<script>
export default {
  name: 'NotificationMessage',
  props: ['notification'],

  computed: {
    typeClass() {
      return `alert-${this.notification.type}`;
    },
  },
  methods: {
    deleteNotification() {
      this.$store.dispatch('deleteNotification', this.notification);
    },
  },
};
</script>

<style>
.close-button {
  border: none;
  border-radius: 50%;
  width: 12%;
  height: 22%;
  margin-right: 5px;
  cursor: pointer;
}

.notification-text {
  margin-top: 1rem;
  align-self: center;
}

.notification-message-container {
  display: flex;
  width: 360px;
}
.alert-success {
  background-color: green;
}
.alert-fail {
  background-color: red;
}
</style>
