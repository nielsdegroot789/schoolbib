<template>
  <div class="ManageUsersIndexContainer">
    <h1>List of all users</h1>
    <Reservations />
  </div>
</template>

<script>
import Reservations from '~/components/Reservations';

export default {
  name: 'Users',
  components: {
    Reservations,
  },
  data: () => {
    return {};
  },
};
</script>

<style></style>
