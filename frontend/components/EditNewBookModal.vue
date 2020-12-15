<template>
  <div class="formDataContainer">
    <div :class="['modal', { 'is-active': active }]">
      <div class="modal-background" @click="closeModal"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p v-if="!book" class="modal-card-title">Add book</p>
          <p v-if="book" class="modal-card-title">Update book id:</p>
          <button
            class="delete"
            aria-label="close"
            @click="closeModal"
          ></button>
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
          <button v-if="book" class="button" @click="sendChanges">
            Update book
          </button>
          <button v-if="!book" class="button" @click="newBook">Add book</button>
        </footer>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'EditNewBook',
  props: {
    book: {
      type: Array,
    },
    active: {
      type: Boolean,
      default: false,
    },
    toggle: {
      type: Function,
    },
  },
  computed: {
    editModal() {
      return this.$store.state.editModal;
    },
    getBookMeta() {
      return this.$store.state.adminSpecificBooks[0].bookMetaId;
    },
    formValues() {
      return this.book[0];
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
      debugger;
      this.toggle();
    },
  },
};
</script>

<style>
.hidden {
  display: none;
}
</style>
