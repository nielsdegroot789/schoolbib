<template>
  <div>
    <BookForm :book-data="bookMeta" @updateBookData="updateBookData" />
  </div>
</template>

<script>
import BookForm from '~/components/BookForm.vue';
export default {
  name: 'EditForm',
  components: { BookForm },
  data() {
    return {
      ready: false,
      bookMeta: {},
    };
  },
  mounted() {
    this.$axios
      .get('getBookMetaFromId', {
        params: { id: this.$route.params.editBook },
        headers: {
          Auth: this.$store.state.JWT,
        },
      })
      .then((response) => {
        this.bookMeta = response.data[0];
      });
  },
  methods: {
    updateBookData(newDataObj) {
      this.bookData = newDataObj;
    },
  },
};
</script>

<style scoped>
.edit-event-page {
  padding: 2rem 4rem;
}
</style>
