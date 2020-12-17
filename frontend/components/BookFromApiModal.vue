<template>
  <div>
    <div class="modal is-active">
      <div class="modal-background" @click="closeModal"></div>
      <div class="modal-card card-width">
        <header class="modal-card-head">
          <p class="modal-card-title">Use following book data?</p>
          <button
            class="delete"
            aria-label="close"
            @click="closeModal"
          ></button>
        </header>
        <section class="modal-card-body card-body">
          <p class="level">
            <span class="level-left">Title:</span>
            <span class="level-right">{{ modalData.title }}</span>
          </p>

          <p class="level">
            <span class="level-left"> Isbn:</span>
            <span class="level-right">
              {{
                modalData.industryIdentifiers
                  ? modalData.industryIdentifiers[1]
                    ? {
                        isbnCode: modalData.industryIdentifiers[1].identifier,
                      }
                    : {
                        isbnCode: modalData.industryIdentifiers[0].identifier,
                      }
                  : { isbnCode: 'No isbn available' }
              }}</span
            >
          </p>

          <p class="level">
            <span class="level-left">Publish Date:</span>
            <span class="level-right">{{
              modalData.publishedDate ? modalData.publishedDate : 'Unavailable'
            }}</span>
          </p>

          <p class="level">
            <span class="level-left"> Rating:</span>
            <span class="level-right">{{
              modalData.averageRating ? modalData.averageRating : 'Unavailable'
            }}</span>
          </p>

          <p class="level">
            <span class="level-left"> Amount of pages:</span>
            <span class="level-right">{{
              modalData.pageCount ? modalData.pageCount : 'Unavailable'
            }}</span>
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
            <span class="level-right">{{
              modalData.language ? modalData.language : 'Unavailable'
            }}</span>
          </p>

          <p class="level">
            <span class="level-left">authors:</span>
            <span class="level-right">{{
              modalData.authors ? modalData.authors : 'Unavailable'
            }}</span>
          </p>

          <p class="level">
            <span class="level-left"> reading level:</span>
            <span class="level-right">{{
              modalData.maturityRating
                ? modalData.maturityRating
                : 'Unavailable'
            }}</span>
          </p>

          <p class="level">
            <span class="level-left"> publisher:</span>
            <span class="level-right">{{
              modalData.publisher ? modalData.publisher : 'Unavailable'
            }}</span>
          </p>

          <p class="level">
            <span class="level-left">category:</span>
            <span class="level-right">
              {{
                modalData.categories ? modalData.categories : 'Unavailable'
              }}</span
            >
          </p>
        </section>
        <footer class="modal-card-foot">
          <button class="button level-item" @click="useData()">Use</button>
          <button class="button level-item" @click="closeModal">Cancel</button>
        </footer>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'APIModal',
  components: {},
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
