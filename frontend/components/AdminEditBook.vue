<template>
  <div>
    <div class="section box">
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
      <button @click="newBook">new</button>
    </div>
    <div :class="['modal', { 'is-active': active }]">
      <div class="modal-background" @click="showModal"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Do you want to delete this book?</p>
          <button class="delete" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
          <button
            class="button is-danger is-halfwidth"
            @click="deleteSpecificBook(item.id)"
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
export default {
  name: 'AdminEditBook',
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
.modal-card {
  max-width: 32%;
}
.modal-card-body {
  display: flex;
  justify-content: space-around;
}
</style>
