<template>
  <div v-if="bookMeta">
    <div>
      <img :src="bookMeta.image" />
    </div>
    <div class="col-8">
      <h1>title : {{ bookMeta.title }}</h1>
      <h3>rating :{{ bookMeta.rating }}</h3>

      <button @click="addToCart()">Add to Cart</button>

      <p>{{ bookMeta.description }}</p>
    </div>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
export default {
  components: {},
  computed: {
    ...mapState('bookMeta', ['bookMeta']),
  },
  mounted() {
    this.getbookMeta();
  },
  methods: {
    ...mapActions('bookMeta', ['getbookMeta']),
  },
};
</script>

<style></style>
