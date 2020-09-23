<template>
  <div class="notify-container">
    <button class="close-button">Close</button>
    <h2>tekst</h2>
  </div>
</template>

<script>
export default {
  name: 'Notification',
};
</script>

<style>
.notify-container {
  position: fixed;
  bottom: 1rem;
  right: 3rem;
  z-index: 5000;
}
.close-button {
  max-width: initial;
}
</style>
