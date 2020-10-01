<template>
  <div>
    EditForm
    <BookForm :book-data="bookData" />
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
      bookData: {},
    };
  },
  computed: {
    bookMeta() {
      return this.$store.getters.getBookMetaById(
        parseInt(this.$route.params.editBook),
      );
    },
    books() {
      return this.$store.getters.getBooksByBookMetaId(
        parseInt(this.$route.params.editBook),
      );
    },
  },
  created() {
    // check if book is already fetched
    this.bookData = this.bookMeta[0];
  },
  methods: {},
};
</script>

<style scoped>
.edit-event-page {
  padding: 2rem 4rem;
}
</style>
