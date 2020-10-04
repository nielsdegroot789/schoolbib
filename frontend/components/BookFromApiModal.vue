<template>
  <div class="modal is-active">
    <div class="modal-background" @click="closeModal"></div>
    <div class="modal-content">
      <div class="modalCenter">
        <div class="section">
          <header class="title">Use following book data?</header>
          <div class="section bookInformation">
            <p class="level">
              <span class="level-left">Title:</span>
              <span class="level-right">{{ modalData.title }}</span>
            </p>
            <p class="level">
              <span class="level-left"> Isbn:</span>
              <span class="level-right">
                {{ modalData.industryIdentifiers[1].identifier }}</span
              >
            </p>
            <p class="level">
              <span class="level-left">Publish Date:</span>
              <span class="level-right">{{ modalData.publishedDate }}</span>
            </p>
            <p class="level">
              <span class="level-left"> Rating:</span>
              <span class="level-right">{{ modalData.averageRating }}</span>
            </p>
            <p class="level">
              <span class="level-left"> Amount of pages:</span>
              <span class="level-right">{{ modalData.pageCount }}</span>
            </p>
            <p class="level">
              <span class="level-left">sticker: </span>
              <span class="level-right">
                {{
                  modalData.imageLinks.smallThumbnail
                    ? 'available'
                    : 'not available'
                }}
              </span>
            </p>
            <p class="level">
              <span class="level-left">language:</span>
              <span class="level-right">{{ modalData.language }}</span>
            </p>
            <p class="level">
              <span class="level-left">authors:</span>
              <span class="level-right">{{ modalData.authors }}</span>
            </p>
            <p class="level">
              <span class="level-left"> reading level:</span>
              <span class="level-right">{{ modalData.maturityRating }}</span>
            </p>
            <p class="level">
              <span class="level-left"> publisher:</span>
              <span class="level-right">{{ modalData.publisher }}</span>
            </p>
            <p class="level">
              <span class="level-left">categories:</span>
              <span class="level-right"> {{ modalData.categories }}</span>
            </p>
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
  width: 200px;
}

.modalCenter {
  background-color: #d3d3d3;
  color: black;
}

.button {
  margin: 0 15px;
}

.bookInformation p:nth-child(even) {
  box-sizing: border-box;
  background-color: #bebebe;
}
</style>
