<template>
  <div class="information-container">
    <h2 class="profile-page-title">EDIT INFORMATION</h2>
    <img src="../assets/pictures/default.png" alt="Standaard-afbeelding" />
    <input type="file" @change="selectPicture" />
    <button>Upload</button>
    <h2 class="profile-page-title">ACOUNT INFORMATION</h2>
    <FormulateForm @submit="save()">
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
      <FormulateInput
        label="Current password"
        type="password"
        input-class="input-style"
        validation="required"
      />
      <FormulateInput
        label="New password"
        input-class="input-style"
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
      <input type="submit" label="Save Changes" />
    </FormulateForm>
  </div>
</template>

<script>
export default {
  name: 'Profileinformation',
  data() {
    return {
      selectedFile: null,
    };
  },
  methods: {
    selectPicture(event) {
      this.selectedFile = event.target.file[0]; // vuex store sturen
    },
    save() {
      this.$store.dispatch('addNotification', {
        type: 'fail',
        message: 'Form saved',
      });
    },
  },
};
</script>

<style></style>
