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
      <p>language: {{ modalData.language }}</p>
      <p>reading level: {{ modalData.maturityRating }}</p>
      <p>publisher: {{ modalData.publisher }}</p>
      <p>categories: {{ modalData.categories }}</p>

      <div class="buttonContainer">
        <button @click="useData(data)">Use</button>
        <button @click="useDataAndExit(data)">Use and exit</button>
        <button @click="closeModal">Cancel</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DeleteModal',
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
    return {
      travel: null,
    };
  },
  computed: {
    shouldShowModal() {
      return this.showModal;
    },
  },
  mounted() {
    this.$root.$on('delete-travel', this.openModal);
  },
  methods: {
    openModal(travel) {
      this.travel = travel;
    },
    closeModal() {
      this.showModal = false;
    },
    useData(id) {
      this.travel = null;
      this.$root.directusClient.deleteItem('travel', id).then(() => {
        this.$root.$emit('notify', `Travel ${id} was deleted`);
        this.$root.$emit('refresh-travels');
      });
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

.delete-modal__window header {
  font-size: 2rem;
  border-bottom: 1px solid grey;
  padding: 1rem;
}

.delete-modal__window main {
  height: 10rem;
  padding: 1rem;
  border-bottom: 1px solid grey;
}

.delete-modal__window footer {
  padding: 1rem;
  display: flex;
  justify-content: flex-end;
}

.delete-modal__window footer button {
  margin-bottom: 0;
  margin-left: 2rem;
}
</style>
