<template>
  <div class="modal">
    <div class="modal-background" @click="closeModal()"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">book</p>
        <button
          class="delete"
          aria-label="close"
          @click="closeModal()"
        ></button>
      </header>
      <section class="modal-card-body">
        <div class="field">
          <div class="control">
            <FormulateForm v-model="formValues">
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
          :class="['button', 'is-success', { hidden: !specificbook }]"
          @click="sendChanges"
        >
          Save changes
        </button>
        <button
          :class="['button', 'is-success', { hidden: specificbook }]"
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
  name: 'EditNewBook',
  props: {
    specificbook: {
      default: () => {
        '';
      },
      type: Object,
    },
  },
  data() {
    return {
      formValues: this.specificbook,
    };
  },
  watch: {
    specificbook() {
      this.formValues = this.specificbook;
    },
  },
  methods: {
    sendChanges() {
      this.$axios
        .put('http://localhost:8080/handleSpecificBook', this.formValues)
        .catch((err) => console.log(err));
      this.closeModal();
    },
    newBook() {
      this.formValues.bookMetaId = this.$store.state.adminSpecificBooks[0].bookMetaId;
      this.$axios.post(
        'http://localhost:8080/handleSpecificBook',
        this.formValues,
      );
      this.closeModal();
    },
    closeModal() {
      this.$store.dispatch('toggleEditModal');
    },
  },
};
</script>

<style>
.hidden {
  display: none;
}
</style>
