<template>
  <div>
    <div class="BookBorrowCard">
      <p>are you sure you want to borrow {{ books.status }}</p>
      <p>{{ books }}</p>
    </div>
    <carousel />
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },
  computed: {
    bookMeta() {
      return this.$store.state.bookMeta;
    },
    filteredMetaBooks() {
      return this.bookMeta.filter((item) => item.title.includes(this.search));
    },
  },
};
</script>

<style>
.BookInfoContainer {
  height: 400px;
}
</style>
