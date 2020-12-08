<template>
  <div class="information-container">
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
      <div>
        <input type="submit" label="Save Changes" />
        <button class="reset-btn--profile" @click="resetPassword">
          Reset password
        </button>
      </div>
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
  },
  created() {
    console.log(this.UserId);
    axios
      .get('http://localhost:8080/getProfilePageData', {
        headers: { Auth: localStorage.getItem('JWT') },
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
        headers: { Auth: this.$store.state.JWT },
      });
    },
    resetPassword() {
      axios({
        method: 'post',
        url: 'http://localhost:8080/resetPassword',
        params: this.formValues.email,
      });
    },
  },
};
</script>

<style></style>
