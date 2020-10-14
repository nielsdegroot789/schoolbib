<template>
  <div>
    <editBookModal />
    <div class="section box">
      <div class="grid-books">
        <div
          v-for="item in adminSpecificBooks"
          :key="item.id"
          :specificBook="item"
          class="div level-box"
        >
          <h1>id : {{ item.id }}</h1>
          <h1>status: {{ item.status }}</h1>
          <h1>qr-code: {{ item.qrCode }}</h1>
          <button class="button" @click="showEditNewModal(item.id)">
            Edit
          </button>
          <button class="button" @click="showDeleteModal(item.id)">
            Delete
          </button>
        </div>
      </div>
      <button class="button" @click="showEditNewModal">New</button>
    </div>

    <div :class="['modal', { 'is-active': deleteActive }]">
      <div class="modal-background" @click="showDeleteModal"></div>
      <div class="modal-card card-width">
        <header class="modal-card-head">
          <p class="modal-card-title">Do you want to delete this book?</p>
          <button
            class="delete"
            aria-label="close"
            @click="showDeleteModal"
          ></button>
        </header>
        <section class="modal-card-body card-body">
          <button
            class="button is-danger is-halfwidth"
            @click="deleteSpecificBook(id)"
          >
            Delete this book
          </button>
        </section>
        <footer class="modal-card-foot"></footer>
      </div>
    </div>
  </div>
</template>

<script>
import editBookModal from '../components/EditNewBookModal';
export default {
  name: 'AdminEditBook',
  components: {
    editBookModal,
  },
  data() {
    return {
      deleteActive: false,
      editNewActive: false,
      specificBook: '',
      currentId: null,
    };
  },
  computed: {
    adminSpecificBooks() {
      return this.$store.state.adminSpecificBooks;
    },
  },
  created() {
    this.$store.dispatch('getAdminSpecificBooks', this.$route.params.book);
  },
  methods: {
    deleteSpecificBook(id) {
      this.$store.dispatch('deleteSpecificBook', id);
      this.showDeleteModal();
    },
    showDeleteModal(id) {
      this.deleteActive = !this.deleteActive;
      this.$store.dispatch('clickedBookDetails');
    },
    showEditNewModal(id) {
      this.$store.dispatch('toggleEditModal', id);
    },
  },
};
</script>

<style>
.card-width {
  max-width: 35%;
}
.card-body {
  display: flex;
  justify-content: space-around;
}
.grid-books {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
}
</style>
