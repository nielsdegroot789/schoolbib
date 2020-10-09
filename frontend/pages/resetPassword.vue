<template>
  <div v-if="tokenValid" reset-password-container>
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
import axios from 'axios';
export default {
  data() {
    return {
      password: '',
      tokenValid: false,
    };
  },
  created() {
    const token = this.$route.query.token;
    console.log(token);
    axios
      .get('http://localhost:8080/checkToken', { params: token })
      .then((response) => console.log(response.data));
  },

  methods: {
    resetPassword() {
      axios
        .post('http://localhost:8080/updatePassword', this.password)
        .then((response) => console.log(response));
    },
  },
};
</script>

<style></style>
