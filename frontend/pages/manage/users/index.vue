<template>
  <div>
    <div v-for="user in users" :key="user.id">
      {{ user.id }}
      {{ user.surname }}
      {{ user.lastname }}
      {{ user.email }}
    </div>
  </div>
</template>

<script>
export default {
  name: 'Users',
  computed: {
    users() {
      return this.$store.state.getUsers;
    },
  },
  created() {
    this.$store.dispatch('getAllUsers');
  },
};
</script>

<style></style>
