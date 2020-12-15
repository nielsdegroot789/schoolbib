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
            <button
              class="button is-dark is-fullwidth"
              @click="successCloseModal"
            >
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
      this.$store.dispatch('openEmailModal');
    },
    successCloseModal() {
      this.$store.dispatch('openEmailModal');
      this.$axios
        .post('resetPassword', this.formValues)
        .then((response) =>
          this.$store.dispatch('addNotification', {
            type: 'success',
            message: 'email has been successfully send',
          }),
        )
        .catch((error) =>
          this.$store.dispatch('addNotification', {
            type: 'fail',
            message: error,
          }),
        );
    },
  },
};
</script>

<style></style>
