<template>
  <div class="bookFormContainer">
    <BookFromApiModal
      v-if="shouldShowModal"
      :modal-data="modalData"
      @closeModal="handleCloseModal"
    />

    <FormulateForm v-model="currentBookData" class="section" @submit="saveBook">
      <FormulateInput v-if="currentBookData.id" type="hidden" name="id" />
      <FormulateInput
        label="isbn"
        type="text"
        name="isbnCode"
        validation="required"
      />
      <FormulateInput
        label="title"
        type="text"
        name="title"
        validation="required"
      />
      <FormulateInput label="publish Date" type="text" name="publishDate" />
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

    <div class="possibleBookResults section">
      <div class="buttonContainer level">
        <button
          class="button is-large level-item"
          @click="searchForBook({ isbn: currentBookData.isbnCode })"
        >
          Search by isbn
        </button>
        <button
          class="button is-large level-item"
          @click="searchForBook({ title: currentBookData.title })"
        >
          Search by title
        </button>
      </div>

      <div v-if="showError" class="notification is-danger">
        <button class="delete" @click="closeError"></button>
        Make sure that the field is filled in correctly!
      </div>

      <p
        v-for="result in bookResults"
        :key="result.id"
        class="level box"
        @click="showModal(result.volumeInfo)"
      >
        <span class="level-left">
          {{ result.volumeInfo.title }}
        </span>
        <button class="button level-right">View book details</button>
      </p>
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
      modalData: {},
      shouldShowModal: false,
      showError: false,
      bookMetaData: Object,
    };
  },
  computed: {
    currentBookData: {
      get() {
        return this.bookData;
      },
      set(newValue) {
        this.bookMetaData = newValue;
      },
    },
  },
  methods: {
    saveBook(data) {
      this.$axios({
        method: 'POST',
        url: 'http://localhost:8080/saveBook',
        headers: { Auth: this.$store.state.JWT },
        data,
      });
    },

    searchForBook(searchObj) {
      let string = '';
      for (const key in searchObj) {
        if (string !== '') string += '+';
        string += key + ':' + searchObj[key];
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

    closeError() {
      this.showError = false;
    },

    showModal(info) {
      this.modalData = info;
      this.shouldShowModal = true;
    },
    handleCloseModal(modalData, shouldRerouteDirectly = false) {
      this.shouldShowModal = false;
      if (modalData) {
        const newDataObj = {
          ...(this.bookData.id && { id: this.bookData.id }),
          ...(modalData.authors && { authors: modalData.authors.join() }),
          ...(modalData.categories && {
            categories: modalData.categories.join(),
          }),
          ...(modalData.industryIdentifiers[1] && {
            isbnCode: modalData.industryIdentifiers[1].identifier,
          }),
          ...(modalData.language && { language: modalData.language }),
          ...(modalData.publishedDate && {
            publishDate: modalData.publishedDate,
          }),
          ...(modalData.publisher && { publishers: modalData.publisher }),
          ...(modalData.averageRating && { rating: modalData.averageRating }),
          ...(modalData.maturityRating && {
            readingLevel: modalData.maturityRating,
          }),
          ...(modalData.imageLinks.smallThumbnail && {
            sticker: modalData.imageLinks.smallThumbnail,
          }),
          ...(modalData.title && { title: modalData.title }),
          ...(modalData.pageCount && { totalPages: modalData.pageCount }),
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
  width: 100%;
  height: 100%;
  display: grid;
  grid-template-columns: 50% 50%;
  position: relative;
}

.box {
  margin-bottom: 0.5rem;
}
</style>
