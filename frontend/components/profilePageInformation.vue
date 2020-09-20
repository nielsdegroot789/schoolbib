<template>
  <div class="information-container">
    <h2 class="profile-page-title">EDIT INFORMATION</h2>
    <img src="../assets/pictures/default.png" alt="Standaard-afbeelding" />
    <h2 class="profile-page-title">ACOUNT INFORMATION</h2>
    <FormulateForm>
      <FormulateInput
        label="First name"
        validation="required"
        input-class="input-style"
      />
      <FormulateInput
        label="Last name"
        validation="required"
        input-class="input-style"
      />
      <FormulateInput
        label="Email"
        validation="required|email"
        input-class="input-style"
      />
      <h2 class="profile-page-title">CHANGE PASSWORD</h2>
      <FormulateInput label="Current password" input-class="input-style" />
      <FormulateInput label="New password" input-class="input-style" />
      <FormulateInput label="Confirm password" input-class="input-style" />
      <FormulateInput
        class="button-formulate"
        type="submit"
        label="Save Changes"
      />
    </FormulateForm>
  </div>
</template>

<script>
export default {
  name: 'Profileinformation',
};
</script>

<style></style>
