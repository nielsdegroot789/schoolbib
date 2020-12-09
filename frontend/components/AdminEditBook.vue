<template>
  <div v-if="currentRole.role == 2">
    <editBookModal />
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
      <button class="button" @click="showEditNewModal">New</button>
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
      deleteActive: false,
      editNewActive: false,
      specificBook: '',
      currentId: null,
      currentRole: '',
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
      this.showDeleteModal();
    },
    showDeleteModal(id) {
      this.$store.dispatch('toggleDeleteModal', id);
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
