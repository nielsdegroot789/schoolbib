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
  methods: {
    sendPassword() {
      console.log('ba');
    },
  },
};
</script>

<style></style>
