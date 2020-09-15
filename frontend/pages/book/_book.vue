<template>
  <div>
    <div class="BookInfoContainer">
      <p>this is specific for book {{ bookMeta.title }}</p>
      <p>{{ books }}</p>
    </div>
    <carousel />
  </div>
</template>

<script>
export default {
  data() {
    return {
      bookId: 0,
      bookData: {},
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
  created() {
    console.log(this.bookMeta);
  },
  methods: {},
};
</script>

<style>
.BookInfoContainer {
  height: 400px;
}
</style>
