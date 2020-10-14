<template>
  <div :class="['modal', { 'is-active': editModal }]">
    <div class="modal-background" @click="closeModal"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p :class="['modal-card-title', { hidden: book.id }]">Add book</p>
        <p :class="['modal-card-title', { hidden: !book.id }]">Update book</p>
        <button class="delete" aria-label="close" @click="closeModal"></button>
        {{ id }}
      </header>
      <section class="modal-card-body">
        <div class="field">
          <div class="control">
            <FormulateForm v-model="book">
              <FormulateInput type="text" name="id" label="id" />
              <FormulateInput type="text" name="stock" label="Stock" />
              <FormulateInput type="text" name="qrCode" label="qr-code" />
              <FormulateInput type="text" name="status" label="status" />
            </FormulateForm>
          </div>
        </div>
      </section>
      <footer class="modal-card-foot">
        <button
          :class="['button', 'is-success', { hidden: !book.id }]"
          @click="sendChanges"
        >
          Save changes
        </button>
        <button
          :class="['button', 'is-success', { hidden: book.id }]"
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
  props: ['book'],

  computed: {
    editModal() {
      return this.$store.state.editModal;
    },
  },
  methods: {
    sendChanges() {
      this.$axios
        .put('http://localhost:8080/handleSpecificBook', this.values)
        .catch((err) => console.log(err));
      this.closeModal();
      this.$store.dispatch('getAdminSpecificBooks', this.$route.params.book);
    },
    newBook() {
      this.formValues.bookMetaId = this.$store.state.adminSpecificBooks[0].bookMetaId;
      this.$axios.post('http://localhost:8080/handleSpecificBook', this.values);
      this.closeModal();
      this.$store.dispatch('getAdminSpecificBooks', this.$route.params.book);
    },
    closeModal() {
      this.$store.dispatch('toggleEditModal');
    },
  },
};
</script>

<style></style>
