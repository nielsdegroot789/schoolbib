<template>
  <div class="formDataContainer">
    <formData :book="specificBook" />
  </div>
</template>

<script>
import formData from '../components/bookFormData';
export default {
  name: 'EditNewBook',
  components: {
    formData,
  },
  computed: {
    specificBook() {
      return this.$store.state.specificBook;
    },
  },
};
</script>

<style>
.hidden {
  display: none;
}
</style>
