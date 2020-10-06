<template>
  <div reset-password-container>
    <FormulateForm v-model="password" @submit="sendPassword">
      <FormulateInput
        label="new password"
        type="password"
        name="password"
        validation="required"
        input-class="input-style"
      />
      <FormulateInput
        label="confirm password"
        type="password"
        name="password_confirm"
        validation="required|confirm"
        validation-name="Password confirmation"
        input-class="input-style"
      />
    </FormulateForm>
    <input type="submit" label="Reset password" />
  </div>
</template>

<script>
export default {
  created() {
    const token = this.$route.query.token;
    this.$store.dispatch('checkToken', token);
  },
  methods: {
    resetPassword(password) {
      this.$store.dispatch('resetPassword');
    },
  },
};
</script>

<style></style>
