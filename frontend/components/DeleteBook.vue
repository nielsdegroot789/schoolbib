<template>
  <div>
    <div :class="['modal', { 'is-active': active }]">
      <div class="modal-background" @click="closeDeleteModal"></div>
      <div class="modal-card card-width">
        <header class="modal-card-head">
          <p class="modal-card-title">Do you want to delete this book?</p>
          <button
            class="delete"
            aria-label="close"
            @click="deleteBook"
          ></button>
        </header>
        <section class="modal-card-body card-body">
          <button class="button is-danger is-halfwidth" @click="deleteBook">
            Delete this book
          </button>
        </section>
        <footer class="modal-card-foot"></footer>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DeleteBook',
  computed: {
    active() {
      return this.$store.state.deleteModal;
    },
    currentBook() {
      return this.$store.getters.specificBook;
    },
  },
  methods: {
    deleteBook() {
      this.$store.dispatch('deleteSpecificBook');
      this.closeDeleteModal();
    },
    closeDeleteModal() {
      this.$store.dispatch('toggleDeleteModal');
    },
  },
};
</script>

<style></style>
