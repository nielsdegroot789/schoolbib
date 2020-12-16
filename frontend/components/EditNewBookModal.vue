<template>
  <div class="formDataContainer">
    <div :class="['modal', { 'is-active': active }]">
      <div class="modal-background" @click="closeModal"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p v-if="!book" class="modal-card-title">Add book</p>
          <p v-if="book" class="modal-card-title">
            Update book id: {{ book[0].id }}
          </p>
          <button
            class="delete"
            aria-label="close"
            @click="closeModal"
          ></button>
        </header>
        <section class="modal-card-body">
          <div class="field">
            <div class="control">
              <FormulateForm v-model="formValues">
                <FormulateInput type="text" name="stock" label="Stock" />
                <FormulateInput type="text" name="qrCode" label="qr-code" />
                <FormulateInput type="text" name="status" label="status" />
              </FormulateForm>
            </div>
          </div>
        </section>
        <footer class="modal-card-foot">
          <button v-if="book" class="button" @click="sendChanges">
            Update book
          </button>
          <button v-if="!book" class="button" @click="newBook">Add book</button>
        </footer>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'EditNewBook',
  props: {
    book: {
      type: Array,
    },
    active: {
      type: Boolean,
      default: false,
    },
    toggle: {
      type: Function,
    },
    clear: {
      type: Function,
    },
  },
  data() {
    return {
      formValues: '',
      bookMetaId: '',
    };
  },

  computed: {
    editModal() {
      return this.$store.state.editModal;
    },
  },
  watch: {
    book(val) {
      this.formValues = this.book[0];
    },
  },
  mounted() {
    this.$axios
      .get('getBookMetaFromId', {
        params: { id: this.$route.params.book },
        headers: {
          Auth: this.$store.state.JWT,
        },
      })
      .then((response) => {
        this.bookMetaId = response.data[0].id;
      });
  },
  methods: {
    sendChanges() {
      this.$axios
        .put('http://localhost:8080/handleSpecificBook', this.formValues, {
          headers: { Auth: localStorage.getItem('JWT') },
        })
        .then(() => {
          this.refreshBooks();
          this.clear();
        })
        .catch((err) => console.log(err));
      this.closeModal();
    },
    refreshBooks() {
      this.$store.dispatch('getAdminSpecificBooks', this.$route.params.book);
    },
    newBook() {
      this.formValues.id = this.bookMetaId;
      const headers = {
        Auth: localStorage.getItem('JWT'),
      };
      this.$axios
        .post('handleSpecificBook', this.formValues, { headers })
        .then((response) => {
          this.refreshBooks();
        });
      this.closeModal();
    },
    closeModal() {
      this.toggle();
      if (this.book) {
        this.clear();
      }
    },
    getBookMetaId() {
      this.$axios
        .get('getBookMetaFromId', {
          params: { id: this.$route.params.book },
          headers: {
            Auth: this.$store.state.JWT,
          },
        })
        .then((response) => {
          this.bookMeta = response.data[0];
        });
    },
  },
};
</script>

<style>
.hidden {
  display: none;
}
</style>
