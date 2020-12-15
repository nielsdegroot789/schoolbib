<template>
  <div v-if="currentRole.role == 2 || currentRole.role == 3">
    <editBookModal :active="active" :book="book" :toggle="toggleEditNewModal" />
    <deleteModal />
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
      <button class="button" @click="showEditNewModal('no-id')">New</button>
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
      if (id === 'no-id') {
      } else {
        this.book = this.adminSpecificBooks.filter((book) => {
          return book.id === id;
        });
      }
      this.active = !this.active;
      //  this.$store.dispatch('toggleEditModal', id);
    },
    toggleEditNewModal() {
      debugger;
      this.active = !this.active;
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
