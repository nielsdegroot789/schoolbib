<template>
  <div class="modal is-active">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">book</p>
        <button class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <FormulateForm v-model="formValues">
          <FormulateInput type="text" name="id" label="id" />
          <FormulateInput type="text" name="stock" label="Stock" />
          <FormulateInput type="text" name="qr-code" label="qr-code" />
          <FormulateInput type="text" name="status" label="status" />
        </FormulateForm>
      </section>
      <footer class="modal-card-foot">
        <button class="button is-success" @click="sendChanges">
          Save changes
        </button>
        <button class="button">Cancel</button>
      </footer>
    </div>
  </div>
</template>

<script>
export default {
  name: 'EditNewBook',
  data() {
    return {
      formValues: '',
    };
  },
  methods: {
    sendChanges() {
      this.$axios.put(
        'http://localhost:8000/handleSpecificBook',
        this.formValues,
      );
    },
  },
};
</script>

<style></style>
