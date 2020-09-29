<template>
  <div>
    <BookForm />
  </div>
</template>

<script>
import BookForm from '../../../components/BookForm.vue';
export default {
  name: 'New',
  components: { BookForm },
  data() {
    return {
      ready: false,
      bookData: {},
    };
  },
  computed: {},
  created() {
    debugger;
  },
  methods: {},
};
</script>

<style scoped>
.edit-event-page {
  padding: 2rem 4rem;
}
</style>
