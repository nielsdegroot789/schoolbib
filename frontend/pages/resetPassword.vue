<template>
  <div>
    <div
      v-if="tokenValid.includes('Valid token')"
      class="reset-password-container"
    >
      <FormulateForm v-model="password">
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
      <input
        class="button is-dark reset-button"
        type="submit"
        label="Reset password"
        @click="resetPassword"
      />
    </div>
    <h1 v-if="tokenValid.includes('Invalid token')">
      Token invalid, please try again
    </h1>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  data() {
    return {
      password: '',
      tokenValid: '',
      userId: '',
    };
  },
  created() {
    const token = this.$route.query.token;
    console.log(token);
    axios
      .get('http://localhost:8080/checkToken', { params: token })
      .then((response) => {
        console.log(response);
        this.tokenValid = response.data.message;
        this.userId = response.data.userId;
      });
  },

  methods: {
    resetPassword() {
      axios
        .post('http://localhost:8080/updatePassword', {
          password: this.password,
          id: this.userId,
        })
        .then((response) =>
          this.$store.dispatch('addNotification', {
            type: 'success',
            message: 'Password has been successfully updated',
          }),
        )
        .then((response) => {
          this.$router.push('/login');
        })
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
