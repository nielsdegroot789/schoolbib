<template>
  <div>
    <BookForm :book-data="bookData" @updateBookData="updateBookData" />
  </div>
</template>

<script>
import BookForm from '~/components/BookForm.vue';
export default {
  name: 'New',
  components: { BookForm },
  data() {
    return {
      ready: false,
      bookData: {},
    };
  },
  methods: {
    updateBookData(newDataObj) {
      debugger;
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
