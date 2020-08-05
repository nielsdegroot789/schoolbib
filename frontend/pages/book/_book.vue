<template>
  <div>
    this is specific for book {{ bookId }}
    {{ books[0] }}
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
    books() {
      return this.$store.state.metaBooks.filter((obj) => {
        return (obj.id = this.bookId);
      });
    },
  },
  mounted() {
    this.bookId = this.$route.params.book;
  },
  methods: {},
};
</script>

<style></style>
