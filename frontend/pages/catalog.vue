<template>
  <div v-if="bookMeta" class="body">
    <div>
      <img :src="bookMeta.image" />
    </div>
    <div>
      <h1>title : {{ bookMeta.title }}</h1>
      <h3>rating :{{ bookMeta.rating }}</h3>

      <button @click="Reserve()">Reserve</button>

      <p>{{ bookMeta.description }}</p>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },
  computed: {
    bookMeta() {
      return this.$store.state.bookMeta;
    },
  },
  method: {
    reserve($id) {},
  },
};
</script>

<style protected>
.body {
  margin: 50px;
}
</style>
