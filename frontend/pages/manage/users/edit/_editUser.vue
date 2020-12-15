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
      .get('getUserFromId', {
        params: { id: this.$route.params.editUser },
        headers: {
          Auth: this.$store.state.JWT,
        },
      })
      .then((response) => {
        this.userMeta = response.data[0];
      });
  },
  methods: {
    updateUserData(newDataObj) {
      this.userData = newDataObj;
    },
  },
};
</script>

<style scoped>
.edit-event-page {
  padding: 2rem 4rem;
}
</style>
