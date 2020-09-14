<template>
  <div>
    <n-link to="/catalog">
      <p>- Back to catalog -</p>
    </n-link>
    <div class="image">
      <p>{{ bookMeta.sticker }}</p>
    </div>
    <div class="information">
      <h1>{{ bookMeta.title }}</h1>
      <p>{{ bookMeta.author }}</p>
      <p>{{ bookMeta.publishDate }}</p>
      <p>{{ bookMeta.rating }} / 5</p>
      <nuxt-link> beoordelingen NTH </nuxt-link>
    </div>

    <Carousel />
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
