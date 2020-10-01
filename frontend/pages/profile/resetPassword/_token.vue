<template>
  <div>
    Password reset:

    <FormulateForm v-model="formValues" @submit="savePassword">
      <FormulateInput
        label="New password"
        type="password"
        name="password"
        validation="required"
      />
      <FormulateInput
        label="Confirm password"
        type="password"
        name="password_confirm"
        validation="required|confirm"
        validation-name="Password confirmation"
      />
      <FormulateInput type="submit" label="Change password" />
    </FormulateForm>
  </div>
</template>

<script>
export default {
  data() {
    return {
      formValues: {},
    };
  },
  methods: {
    savePassword() {
      const token = this.$route.params.token;
      this.$axios.post('localhost:8080/confirmPasswordReset', {
        password: this.formValues.password,
        token,
      });
    },
  },
};
</script>

<style></style>
