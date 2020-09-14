<template>
  <div>
    <BookForm :book-data="bookData" />
  </div>
</template>

<script>
import BookForm from '../../components/BookForm.vue';
export default {
  name: 'EditForm',
  components: { BookForm },
  data() {
    return {
      ready: false,
      bookData: {},
    };
  },
  computed: {
    bookMeta() {
      return this.$store.getters.getBookMetaById(
        parseInt(this.$route.params.editBook),
      );
    },
    books() {
      return this.$store.getters.getBooksByBookMetaId(
        parseInt(this.$route.params.editBook),
      );
    },
  },
  created() {
    // check if book is already fetched
    this.bookData = this.bookMeta[0];

    // todo this needs to be remade with actual backend
    // this.$root.directusClient
    //   .getItems('travel', {
    //     filter: {
    //       id: {
    //         eq: this.$route.params.id,
    //       },
    //     },
    //     fields: '*.*',
    //   })
    //   .then(
    //     function (result) {
    //       if (!result.data) {
    //         throw new Error('Could not find travel');
    //       }
    //       this.bookData = result.data[0];
    //       this.ready = true;
    //     }.bind(this), // if this is not bound you can not access this in the callback (you could also use an arrow function
    //   )
    //   .catch(
    //     function (error) {
    //       console.error(error);
    //       this.$root.$emit('notify', {
    //         title: 'Travel not found',
    //         body: `Travel with id ${this.$root.params.id} not found`,
    //       });
    //     }.bind(this),
    //   );
  },
  methods: {},
};
</script>

<style scoped>
.edit-event-page {
  padding: 2rem 4rem;
}
</style>
