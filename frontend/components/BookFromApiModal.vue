<template>
  <div class="modal is-active">
    <div class="modal-background" @click="closeModal"></div>
    <div class="modal-content">
      <div class="modalCenter">
        <div class="section">
          <header>Use following book data?</header>
          <div class="section">
            <p>Title: {{ modalData.title }}</p>
            <p>Isbn: {{ modalData.industryIdentifiers[1].identifier }}</p>
            <p>Publish Date: {{ modalData.publishedDate }}</p>
            <p>Rating: {{ modalData.averageRating }}</p>
            <p>Amount of pages: {{ modalData.pageCount }}</p>
            <p class="noOverflow">
              sticker: {{ modalData.imageLinks.smallThumbnail }}
            </p>
            <p>language: {{ modalData.language }}</p>
            <p>authors: {{ modalData.authors }}</p>
            <p>reading level: {{ modalData.maturityRating }}</p>
            <p>publisher: {{ modalData.publisher }}</p>
            <p>categories: {{ modalData.categories }}</p>
          </div>
          <div class="buttonContainer level">
            <button class="button level-item" @click="useData()">Use</button>
            <button class="button level-item" @click="useDataAndExit()">
              Use and exit
            </button>
            <button class="button level-item" @click="closeModal">
              Cancel
            </button>
          </div>
        </div>
      </div>
      <button class="modal-close is-large" aria-label="close"></button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'APIModal',
  props: {
    showModal: {
      type: Boolean,
      default: false,
    },
    modalData: {
      type: Object,
      default() {
        return {};
      },
    },
  },
  data() {
    return {};
  },
  computed: {
    shouldShowModal() {
      return this.showModal;
    },
  },
  methods: {
    closeModal() {
      this.$emit('closeModal', false, false);
    },
    useData(id) {
      this.$emit('closeModal', this.modalData, false);
      // todo fill in book data in form
    },
    useDataAndExit(id) {
      this.$emit('closeModal', this.modalData, true);
      // todo fill book data, save and return to main crud screen?
    },
  },
};
</script>

<style scoped>
.noOverflow {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  width: 70%;
}

.modalCenter {
  background-color: gray;
  color: black;
}

.button {
  margin: 0 15px;
}
</style>
