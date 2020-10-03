<template>
  <div class="information-container">
    <h2 class="profile-page-title">EDIT INFORMATION</h2>
    <img src="../assets/pictures/default.png" alt="Standaard-afbeelding" />
    <input type="file" @change="selectPicture" />
    <button>Upload</button>
    <h2 class="profile-page-title">ACOUNT INFORMATION</h2>
    <FormulateForm v-model="formValues" @submit="postData()">
      <FormulateInput
        name="firstName"
        label="First name"
        validation="required"
        input-class="input-style"
      />
      <FormulateInput
        name="lastName"
        label="Last name"
        validation="required"
        input-class="input-style"
      />
      <FormulateInput
        name="email"
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
import axios from 'axios';
export default {
  name: 'Profileinformation',
  data() {
    return {
      selectedFile: null,
      formValues: {
        firstName: '',
        lastName: '',
        email: '',
        currentUser: '',
      },
    };
  },
  computed: {
    UserId() {
      return this.$store.state.currentUser;
    },
    JWT() {
      return this.$store.state.JWT;
    },
  },
  created() {
    console.log(this.UserId);
    axios
      .get('http://localhost:8080/getProfilePageData', {
        params: {
          data: this.UserId,
        },
      })
      .then((response) =>
        (this.formValues.firstName = response.data[0].surname)(
          (this.formValues.lastName = response.data[0].lastname),
          (this.formValues.email = response.data[0].email),
        ),
      );
  },
  methods: {
    selectPicture(event) {
      this.selectedFile = event.target.file[0]; // vuex store sturen
    },
    save() {
      this.$store.dispatch('addNotification', {
        type: 'success',
        message: 'Form saved',
      });
    },
    postData() {
      this.formValues.currentUser = this.UserId.id;
      axios({
        method: 'post',
        url: 'http://localhost:8080/saveProfileData',
        data: this.formValues,
      });
    },
  },
};
</script>

<style></style>
