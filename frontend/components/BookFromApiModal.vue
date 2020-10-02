<template>
  <div
    :class="shouldShowModal ? 'modalBackground' : 'hide'"
    @click.self="closeModal"
  >
    <div v-if="modalData" class="modalCenter">
      <header>Use following book data?</header>
      <p>Title: {{ modalData.title }}</p>
      <p>Isbn: {{ modalData.industryIdentifiers[1].identifier }}</p>
      <p>Publish Date: {{ modalData.publishedDate }}</p>
      <p>Rating: {{ modalData.averageRating }}</p>
      <p>Amount of pages: {{ modalData.pageCount }}</p>
      <p>sticker: {{ modalData.imageLinks.smallThumbnail }}</p>
      <p>language: {{ modalData.language }}</p>
      <p>authors: {{ modalData.authors }}</p>
      <p>reading level: {{ modalData.maturityRating }}</p>
      <p>publisher: {{ modalData.publisher }}</p>
      <p>categories: {{ modalData.categories }}</p>

      <div class="buttonContainer">
        <button @click="useData()">Use</button>
        <button @click="useDataAndExit()">Use and exit</button>
        <button @click="closeModal">Cancel</button>
      </div>
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
.hide {
  display: none;
}
.modalBackground {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 1;
  display: flex;
  justify-content: center;
  align-items: center;
}

.modalCenter {
  background-color: white;
  width: 50%;
  border-radius: 0.5rem;
  box-shadow: 0 1px 5px rgba(0, 0, 0, 0.46);
}
</style>
