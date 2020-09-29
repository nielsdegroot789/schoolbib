<template>
  <div :class="typeClass" class="notification-message-container">
    <button class="close-button" @click="deleteNotification()">
      <font-awesome-icon :icon="['fa', 'times']" />
    </button>
    <p>{{ notification.message }}</p>
  </div>
</template>

<script>
import { mapActions } from 'vuex';
export default {
  name: 'NotificationMessage',
  props: ['notification'],
  data() {
    return {
      timeOut: null,
    };
  },
  computed: {
    typeClass() {
      return `alert-${this.notification.type}`;
    },
  },
  beforeDestroy() {
    clearTimeout(this.timeOut);
  },
  created() {
    this.timeOut = setTimeout(() => {
      this.deleteNotification(this.notification);
    }, 3000);
  },
  methods: {
    ...mapActions(['deleteNotification']),
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
