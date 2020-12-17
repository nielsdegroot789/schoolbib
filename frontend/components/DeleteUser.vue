<template>
  <div>
    <div :class="['modal', { 'is-active': isActive }]">
      <div class="modal-background" @click="closeDeleteModal"></div>
      <div class="modal-card card-width">
        <header class="modal-card-head">
          <p class="modal-card-title">Do you want to delete this user?</p>
          <button
            class="delete"
            aria-label="close"
            @click="closeDeleteModal"
          ></button>
        </header>
        <section class="modal-card-body card-body">
          <button class="button is-danger is-halfwidth" @click="deleteUser">
            Delete this user
          </button>
        </section>
        <footer class="modal-card-foot"></footer>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DeleteUser',
  props: {
    id: {
      type: Number,
      default: -1,
    },
    active: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      isModalActive: false,
    };
  },
  computed: {
    isActive() {
      return this.active;
    },
    userId() {
      return this.id;
    },
  },
  methods: {
    deleteUser() {
      this.$axios
        .delete('deleteUser', {
          headers: { Auth: localStorage.getItem('JWT') },
          params: { id: this.id },
        })
        .then((response) => {
          this.closeDeleteModal();
        });
    },

    closeDeleteModal() {
      this.$emit('closeModal');
    },
  },
};
</script>

<style></style>
