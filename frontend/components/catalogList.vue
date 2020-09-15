<template>
  <div class="d-flex align-items-stretch flex-wrap">
    <catalog-card v-for="bookMeta in bookMeta" :key="bookMeta.id" :bookMeta="bookMeta" />
  </div>
</template>

<script>
import { mapState, mapActions } from "vuex";
export default {
  components: {
  },
  // computed: {
  //   ...mapState("books", ["bookMeta"])
  // },
  mounted() {
    this.getbookMeta();
  },
  // methods: {
  //   ...mapActions("bookMeta", ["bookMeta"])
  // }
};
</script>



<style>
</style>