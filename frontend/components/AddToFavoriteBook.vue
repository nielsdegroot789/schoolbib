<template>
  <div class="favoritediv">
    <button @click="addToFavoriteBookList()">Add To favorite</button>
  </div>
</template>

<script>
export default {
  name: 'AddToFavoriteBook',

  data() {
    return {};
  },
  methods: {
    addToFavoriteBookList() {
      this.$axios
        .post('http://localhost:8080/addToFavoriteBookList', {
          bookMetaId: this.$route.params.book,
          usersId: this.currentUserId,
        })
        .then(function (response) {});
    },

    saveCheckoutNotif() {
      this.$store.dispatch('addNotification', {
        type: 'success',
        message: 'Form saved',
      });
    },
  },
};
</script>

<style></style>
