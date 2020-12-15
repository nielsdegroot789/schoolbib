<template>
  <div>
    <UserForm :user-data="userData" @updateUserData="updateUserData" />
  </div>
</template>

<script>
import UserForm from '~/components/UserForm.vue';
export default {
  name: 'New',
  components: { UserForm },
  data() {
    return {
      ready: false,
      userData: {},
    };
  },
  methods: {
    updateUserData(newDataObj) {
      const headers = {
        Auth: localStorage.getItem('JWT'),
      };
      const { id, surname, lastname, email } = newDataObj;
      this.$axios
        .post(
          'saveProfileData',
          {
            currentUser: id,
            firstName: surname,
            lastName: lastname,
            email,
          },
          {
            headers,
          },
        )
        .then((response) => {});
    },
  },
};
</script>

<style scoped>
.edit-event-page {
  padding: 2rem 4rem;
}
</style>
