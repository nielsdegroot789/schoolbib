<template>
  <FormulateForm :values="bookData" @submit="saveBook">
    <FormulateInput v-if="bookData.id" type="hidden" name="id" />
    <FormulateInput
      label="title"
      type="text"
      name="title"
      validation="required|max:200"
    />
    <FormulateInput label="isbn" type="text" name="isbnCode" />
    <FormulateInput label="publish Date" type="date" name="publishDate" />
    <FormulateInput label="rating" type="text" name="rating" />
    <FormulateInput label="total Pages" type="text" name="totalPages" />
    <FormulateInput label="sticker" type="text" name="sticker" />
    <FormulateInput label="language" type="text" name="language" />
    <FormulateInput label="authors" type="text" name="authors" />
    <FormulateInput label="reading Level" type="text" name="readingLevel" />
    <FormulateInput label="publishers" type="text" name="publishers" />
    <FormulateInput label="categories" type="text" name="categories" />

    <FormulateInput type="submit" label="Save" />
  </FormulateForm>
</template>

<script>
export default {
  name: 'Bookform',
  props: {
    bookData: {
      type: Object,
      default() {
        return {};
      },
    },
  },
  data() {
    return {};
  },
  methods: {
    saveBook(data) {
      this.$store.dispatch('saveBook', data);
    },
  },
};
</script>

<style scoped></style>
