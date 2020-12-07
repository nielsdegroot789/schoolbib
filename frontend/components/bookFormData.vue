<template>
  <div :class="['modal', { 'is-active': editModal }]">
    <div class="modal-background" @click="closeModal"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p :class="['modal-card-title', { hidden: !book.empty }]">Add book</p>
        <p :class="['modal-card-title', { hidden: book.empty }]">
          Update book id: {{ formValues.id }}
        </p>
        <button class="delete" aria-label="close" @click="closeModal"></button>
      </header>
      <section class="modal-card-body">
        <div class="field">
          <div class="control">
            <FormulateForm v-model="formValues">
              <FormulateInput type="text" name="stock" label="Stock" />
              <FormulateInput type="text" name="qrCode" label="qr-code" />
              <FormulateInput type="text" name="status" label="status" />
            </FormulateForm>
          </div>
        </div>
      </section>
      <footer class="modal-card-foot">
        <button
          :class="['button', 'is-success', { hidden: book.empty }]"
          @click="sendChanges"
        >
          Save changes
        </button>
        <button
          :class="['button', 'is-success', { hidden: !book.empty }]"
          @click="newBook"
        >
          Add book
        </button>
      </footer>
    </div>
  </div>
</template>

<script>
export default {
  name: 'BookFormData',
  props: {
    book: {
      type: Object,
      default() {
        return { empty: true };
      },
      required: true,
    },
  },
  data() {
    return {
      formValues: this.book,
    };
  },
  computed: {
    editModal() {
      return this.$store.state.editModal;
    },
    getBookMeta() {
      return this.$store.state.adminSpecificBooks[0].bookMetaId;
    },
  },
  watch: {
    book(book) {
      this.formValues = book;
    },
  },
  methods: {
    sendChanges() {
      this.$axios
        .put('http://localhost:8080/handleSpecificBook', this.formValues, {
          headers: { Auth: localStorage.getItem('JWT') },
        })
        .then(() => {
          this.refreshBooks();
        })
        .catch((err) => console.log(err));
      this.closeModal();
    },
    refreshBooks() {
      this.$store.dispatch('getAdminSpecificBooks', this.$route.params.book);
    },
    newBook() {
      this.formValues.bookMetaId = this.getBookMeta;
      this.$axios
        .post('http://localhost:8080/handleSpecificBook', this.formValues, {
          headers: { Auth: localStorage.getItem('JWT') },
        })
        .then(() => {
          this.refreshBooks();
        });
      this.closeModal();
    },
    closeModal() {
      this.$store.dispatch('toggleEditModal');
    },
  },
};
</script>

<style></style>
