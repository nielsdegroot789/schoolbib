<template>
  <div>
    <div :class="['modal', { 'is-active': active }]">
      <div class="modal-background" @click="closeModal"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title has-text-centered is-small">
            Reset password
          </p>
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
                <FormulateInput
                  name="email"
                  type="email"
                  validation="required|email"
                  input-class="input"
                  placeholder="Enter email"
                />
              </FormulateForm>
            </div>
            <br />
            <button class="button is-dark is-fullwidth" @click="closeModal">
              Reset password
            </button>
          </div>
        </section>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'SendEmailModal',
  data() {
    return {
      formValues: {},
    };
  },
  computed: {
    active() {
      return this.$store.state.emailModal;
    },
  },
  methods: {
    closeModal() {
      this.$store.dispatch('openEmailModal', this.formValues.email);
    },
  },
};
</script>

<style></style>
