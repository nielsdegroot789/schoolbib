<template>
  <div class="favoritediv">
    <button
      @click="
        addToFavoriteBookList();
        saveCheckoutNotif();
      "
    >
      Add To favorite
    </button>
  </div>
</template>

<script>
export default {
  name: 'AddToFavoriteBook',

  data() {
    return {};
  },
  computed: {
    currentUserId() {
      return this.$store.state.currentUser.id;
    },
  },

  mounted() {
    this.booksId = this.$route.params.books;
  },
  methods: {
    addToFavoriteBookList() {
      this.$axios
        .post('http://localhost:8080/addToFavoriteBookList', {
          bookMetaId: this.booksId,
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
