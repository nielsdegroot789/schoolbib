<template>
  <div v-if="bookMeta">
    <div>
      <img :src="bookMeta.image" />
    </div>
    <div>
      <h1>title : {{ bookMeta.title }}</h1>
      <h3>rating :{{ bookMeta.rating }}</h3>

      <button @click="addToCart()">Add to Cart</button>

      <p>{{ bookMeta.description }}</p>
    </div>
  </div>
</template>

<script>
var application = new Vue({
  el: '#catalogus',
  data: {
    allData: '',
  },
  methods: {
    fetchAllData() {
      axios
        .get('BookController.php', {
          action: 'fetchall',
        })
        .then(function (response) {
          application.allData = response.data;
        });
    },
  },
});
</script>

<style></style>
