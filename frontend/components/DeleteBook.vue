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
            @click="closeDeleteModal"
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
  props: {
    books: [Array],
  },
  computed: {
    active() {
      return this.$store.state.deleteModal;
    },
    bookId() {
      return this.$store.state.specificBook;
    },
  },
  methods: {
    deleteBook() {
      if (this.$route.name === 'manage-books') {
        const id = this.bookId;
        console.log(this.bookId);
        this.$axios
          .delete('deleteBookMeta', {
            headers: { Auth: localStorage.getItem('JWT') },
            params: id,
          })
          .then((response) => {
            this.updateBooks();
          });
      } else {
        this.$store.dispatch('deleteSpecificBook');
      }
      this.closeDeleteModal();
    },
    closeDeleteModal() {
      this.$store.dispatch('toggleDeleteModal');
    },
    updateBooks() {
      const newBooks = this.books.filter((books) => {
        return books.id !== this.bookId;
      });
      this.$emit('setNewBookMeta', newBooks);
      console.log(newBooks);
    },
  },
};
</script>

<style></style>
