<template>
  <div class="bookFormContainer">
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
    <div class="possibleBookResults">
      <button @click="searchForBook">Search</button>
      <div v-for="result in bookResults" :key="result.id">
        {{ result.volumeInfo.title }}
      </div>
    </div>
  </div>
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
    return {
      bookResults: [],
    };
  },
  methods: {
    saveBook(data) {
      this.$store.dispatch('saveBook', data);
    },
    searchForBook() {
      // Example URL https://www.googleapis.com/books/v1/volumes?q=isbn:9780553213102+inauthor:jane&key=AIzaSyBFgcdVYDuw2EzuxaaUQZ45PMZw8Q5ksxs
      const filterParams = {
        isbn: '9780553213102',
      };
      let string = '';
      const key = 'AIzaSyBFgcdVYDuw2EzuxaaUQZ45PMZw8Q5ksxs';
      for (const key in filterParams) {
        if (string !== '') string += '+';
        string += key + ':' + filterParams[key];
      }
      console.log(string);

      // todo make params not url encode
      this.$axios({
        method: 'GET',
        url:
          'https://www.googleapis.com/books/v1/volumes?q=' +
          string +
          '&key=' +
          key,
      })
        .then((response) => {
          console.log(response.data.items);
          this.bookResults = response.data.items;
          debugger;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>

<style scoped>
.bookFormContainer {
  display: flex;
}
</style>
