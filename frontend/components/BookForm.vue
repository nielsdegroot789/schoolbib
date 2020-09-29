<template>
  <div class="bookFormContainer">
    <BookFromApiModal
      :show-modal="shouldShowModal"
      :modal-data="modalData"
      @closeModal="handleCloseModal"
    />
    <FormulateForm :values="currentBookData" @submit="saveBook">
      <FormulateInput v-if="currentBookData.id" type="hidden" name="id" />
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
      <div
        v-for="result in bookResults"
        :key="result.id"
        @click="showModal(result.volumeInfo)"
      >
        {{ result.volumeInfo.title }}
        <button>View book details</button>
      </div>
    </div>
  </div>
</template>

<script>
import BookFromApiModal from '~/components/BookFromApiModal';
export default {
  name: 'Bookform',
  components: {
    BookFromApiModal,
  },
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
      modalData: null,
      shouldShowModal: false,
    };
  },
  computed: {
    currentBookData() {
      return this.bookData;
    },
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
      for (const key in filterParams) {
        if (string !== '') string += '+';
        string += key + ':' + filterParams[key];
      }

      this.$axios({
        method: 'GET',
        url: 'https://www.googleapis.com/books/v1/volumes?q=' + string,
        params: {
          key: 'AIzaSyBFgcdVYDuw2EzuxaaUQZ45PMZw8Q5ksxs',
        },
      })
        .then((response) => {
          this.bookResults = response.data.items;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    showModal(info) {
      this.modalData = info;
      this.shouldShowModal = true;
    },
    handleCloseModal(modalData = {}, shouldRerouteDirectly = false) {
      this.shouldShowModal = false;
      if (modalData !== {}) {
        const newDataObj = {
          id: this.bookData.id,
          authors: modalData.authors,
          categories: modalData.categories,
          isbnCode: modalData.industryIdentifiers[1].identifier,
          language: modalData.language,
          publishDate: modalData.publishedDate,
          publishers: modalData.publisher,
          rating: modalData.averageRating,
          readingLevel: modalData.maturityRating,
          sticker: modalData.imageLinks.smallThumbnail,
          title: modalData.title,
          totalPages: modalData.pageCount,
        };
        this.$emit('updateBookData', newDataObj);
      }
      console.log(shouldRerouteDirectly);
    },
  },
};
</script>

<style scoped>
.bookFormContainer {
  display: flex;
}
</style>
