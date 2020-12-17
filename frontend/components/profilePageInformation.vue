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
      <div class="profile-buttons--edit">
        <input type="submit" label="Save Changes" />
        <button class="reset-btn--profile" @click="resetPassword">
          Reset password
        </button>
      </div>
    </FormulateForm>
  </div>
</template>

<script>
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
    this.$axios
      .get('getProfilePageData', {
        headers: { Auth: localStorage.getItem('JWT') },
        params: {
          data: this.UserId,
        },
      })
      .then((response) => {
        this.formValues.firstName = response.data[0].surname;
        this.formValues.lastName = response.data[0].lastname;
        this.formValues.email = response.data[0].email;
      });
  },
  methods: {
    save() {
      this.$store.dispatch('addNotification', {
        type: 'success',
        message: 'Form saved',
      });
    },
    postData() {
      this.formValues.currentUser = this.UserId.id;
      this.$axios({
        method: 'post',
        url: 'saveProfileData',
        data: this.formValues,
        headers: { Auth: this.$store.state.JWT },
      });
    },
    resetPassword() {
      this.$axios.post('resetPassword', this.formValues);
    },
  },
};
</script>

<style></style>
