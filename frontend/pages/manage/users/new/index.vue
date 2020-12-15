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
