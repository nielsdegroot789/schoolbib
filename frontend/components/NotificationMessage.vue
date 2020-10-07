<template>
  <div :class="typeClass" class="notification-message-container">
    <button class="close-button" @click="deleteNotification()">
      <font-awesome-icon :icon="['fa', 'times']" />
    </button>
    <p class="notification-text">{{ notification.message }}</p>
  </div>
</template>

<script>
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
      this.$store.dispatch('deleteNotification', this.notification);
    }, 4000);
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
  position: absolute;
  top: 10px;
  right: 3px;
  background-color: inherit;
  border: none;
  width: 12%;
  height: 22%;
  cursor: pointer;
}

.notification-text {
  color: #fff;
}

.notification-message-container {
  border-radius: 1em;
  width: 300px;
  height: 70px;
  display: flex;
  justify-content: center;
  align-items: center;
}
.alert-success {
  background-color: rgb(50, 205, 50);
}
.alert-fail {
  background-color: rgb(205, 92, 92);
}
.alert-normal {
  background-color: blue;
}
</style>
