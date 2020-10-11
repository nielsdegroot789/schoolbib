<template>
  <div class="modal is-active">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">Do you want to delete this book?</p>
        <button class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <button class="button is-danger is-halfwidth">Delete this book</button>
        <button class="button is-half is-halfwidth">Cancel</button>
      </section>
      <footer class="modal-card-foot"></footer>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DeleteSpecificBookModal',
  computed: {
    active() {
      return this.$store.state.deleteBookModal;
    },
  },
};
</script>

<style>
.modal-card {
  max-width: 32%;
}
.modal-card-body {
  display: flex;
  justify-content: space-around;
}
</style>
