<template>
  <div>
    <UserForm :user-data="userMeta" @updateUserData="updateUserData" />
  </div>
</template>

<script>
import UserForm from '~/components/UserForm.vue';
export default {
  name: 'EditForm',
  components: { UserForm },
  data() {
    return {
      ready: false,
      userMeta: {},
    };
  },
  mounted() {
    this.$axios
      .get('getProfilePageData', {
        headers: { Auth: localStorage.getItem('JWT') },
        params: {
          data: { id: +this.$route.params.editUser },
        },
      })
      .then((response) => {
        this.userMeta = response.data[0];
        this.userMeta.id = this.$route.params.editUser;
      });
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
