<template>
  <div v-if="bookMeta" id="myapp">
    <img :src="bookMeta.sticker" alt="" />
    <td>{{ bookMeta.title }}</td>
    <td>{{ bookMeta.rating }}</td>
  </div>
</template>

<script>
import { mapState, mapActions } from "vuex";
import ProductCard from "./ProductCard";
export default {
  components: {
    ProductCard
  },
  computed: {
    ...mapState("bookMeta", ["bookMeta"])
  },
  mounted() {
    this.getbookMeta();
  },
  methods: {
    ...mapActions("books", ["bookMeta"])
  }
};
</script>

<style>
</style>