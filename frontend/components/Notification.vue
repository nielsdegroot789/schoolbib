<template>
  <div v-if="show" class="notify-container">
    <button class="close-button" @click="deleteNotification()">
      <font-awesome-icon :icon="['fa', 'times']" />
    </button>
    <h2 class="notification-text">Changes saved</h2>
  </div>
</template>

<script>
export default {
  name: 'Notification',
  computed: {
    show() {
      return this.$store.state.show;
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
  background-color: grey;
  width: 200px;
  height: 100px;
  bottom: 1rem;
  right: 3rem;
  z-index: 5000;
  display: flex;
  flex-direction: column;
  align-items: flex-end;
}
.close-button {
  max-width: 100px;
}
.notification-text {
  margin-top: 1rem;
  align-self: center;
}
</style>
