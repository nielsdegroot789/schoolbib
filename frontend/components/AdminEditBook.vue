<template>
  <div>
    <editBookModal />
    <div class="section box">
      <div>
        <div
          v-for="item in adminSpecificBooks"
          :key="item.id"
          class="div level-box"
        >
          <h1>id : {{ item.id }}</h1>
          <h1>status: {{ item.status }}</h1>
          <button>Edit</button>
          <button @click="showModal">Delete</button>
        </div>
      </div>
      <button>New</button>
    </div>

    <div :class="['modal', { 'is-active': active }]">
      <div class="modal-background" @click="showModal"></div>
      <div class="modal-card card-width">
        <header class="modal-card-head">
          <p class="modal-card-title">Do you want to delete this book?</p>
          <button class="delete" aria-label="close" @click="showModal"></button>
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
      active: false,
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
      this.showModal();
    },
    showModal() {
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
</style>
