<template>
  <div class="information-container">
    <h2 class="profile-page-title">EDIT INFORMATION</h2>
    <img src="../assets/pictures/default.png" alt="Standaard-afbeelding" />
    <input type="file" @change="selectPicture" />
    <button>Upload</button>
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
      <input type="submit" label="Save Changes" @click="save()" />
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
      this.$store.dispatch('showNotification', 'Changes saved');
    },
  },
};
</script>

<style></style>
