<template>
  <div>
    <p>this is specific for book {{ bookMeta.title }}</p>
    <p>{{ books }}</p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      bookId: 0,
      bookData: [],
    };
  },
  computed: {
    bookMeta() {
      return this.$store.getters.getBookMetaById(
        parseInt(this.$route.params.book),
      );
    },
    books() {
      return this.$store.getters.getBooksByBookMetaId(
        parseInt(this.$route.params.book),
      );
    },
  },
  mounted() {
    this.bookId = this.$route.params.book;
  },
  methods: {},
};
</script>

<style></style>
