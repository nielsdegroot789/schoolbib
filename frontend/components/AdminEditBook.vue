<template>
  <div v-if="currentRole.role == 2 || currentRole.role == 3">
    <editBookModal
      :active="active"
      :book="book"
      :toggle="toggleEditNewModal"
      :clear="clearBookProp"
    />
    <deleteModal />
    <div class="section box container--admin-edit">
      <div class="grid-books">
        <div
          v-for="item in adminSpecificBooks"
          :key="item.id"
          :specificBook="item"
          class="book-container--admin-edit"
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
      <button
        class="button new-button--admin"
        @click="showEditNewModal('no-id')"
      >
        New
      </button>
    </div>
  </div>
</template>

<script>
import deleteModal from '../components/deleteBook';
import editBookModal from '../components/EditNewBookModal';
export default {
  name: 'AdminEditBook',
  components: {
    editBookModal,
    deleteModal,
  },
  data() {
    return {
      editNewActive: false,
      book: '',
      currentId: null,
      currentRole: '',
      active: false,
    };
  },
  computed: {
    adminSpecificBooks() {
      return this.$store.state.adminSpecificBooks;
    },
    currentUserRole() {
      return this.$store.state.currentUser;
    },
  },
  watch: {
    currentUserRole(n, o) {
      this.currentRole = n;
    },
  },
  created() {
    this.$store.dispatch('getAdminSpecificBooks', this.$route.params.book);
  },
  mounted() {
    this.currentRole = this.$store.state.currentUser;
  },
  methods: {
    deleteSpecificBook(id) {
      this.$store.dispatch('deleteSpecificBook', id);
    },
    showDeleteModal(id) {
      this.$store.dispatch('setDeleteId', id);
      this.$store.dispatch('toggleDeleteModal');
    },
    showEditNewModal(id) {
      if (id !== 'no-id') {
        this.book = this.adminSpecificBooks.filter((book) => {
          return book.id === id;
        });
      }
      this.toggleEditNewModal();
    },
    toggleEditNewModal() {
      this.active = !this.active;
    },
    clearBookProp() {
      this.book = '';
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
  grid-template-columns: repeat(5, 1fr);
}
.book-container--admin-edit {
  margin-top: 2rem;
}
.container--admin-edit {
  padding-top: 1rem;
}
.new-button--admin {
  margin-top: 2rem;
}

@media only screen and (max-width: 940px) {
  .grid-books {
    grid-template-columns: repeat(4, 1fr);
  }
}

@media only screen and (max-width: 800px) {
  .grid-books {
    grid-template-columns: repeat(3, 1fr);
  }
}

@media only screen and (max-width: 565px) {
  .grid-books {
    grid-template-columns: repeat(2, 1fr);
  }
}
</style>
