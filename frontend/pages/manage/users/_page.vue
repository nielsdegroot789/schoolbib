<template>
  <div>
    <div v-if="loggedIn" class="container">
      <div>
        <div v-if="!isApiReady">
          <Loading />
        </div>
        <div v-if="isApiReady" class="peopleContainer">
          <p>Specific information about students goes here</p>
        </div>
        <Pagination />
      </div>
    </div>
    <div v-else>
      Sorry, this page is only available for admin/arch users. If you are one
      make sure you are logged in.
    </div>
  </div>
</template>

<script>
import Loading from '~/components/Loading';
import Pagination from '~/components/Pagination';

export default {
  components: {
    Loading,
    Pagination,
  },
  data() {
    return {
      people: Array,
      pagesCount: Number,
      isApiReady: Boolean,
    };
  },
  computed: {
    currentPage() {
      return parseInt(this.$route.params.page);
    },
    loggedIn() {
      return this.$store.state.JWT;
    },
  },
  methods: {},
};
</script>

<style></style>
