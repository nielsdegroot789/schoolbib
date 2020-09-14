<template>
  <div class="containerCard">
    <n-link :to="/book/ + bookMeta.id">
      <div v-for="(item, index) in bookMeta" :key="index">
        <div class="card">
          <div class="image">
            <img src="bookMeta.sticker" />
          </div>
          <h1>{{ bookMeta.title }} booktitle</h1>
          <p class="price">4/ 5</p>
          <p>
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sunt est
            repudiandae recusandae rem. . {{ bookMeta.description }}
          </p>
          <button @click.native="Borrow(currentBookMeta)">Add to cart</button>
        </div>
      </div>
    </n-link>
  </div>
</template>

<script>
import { mapActions } from 'vuex';

export default {
  data() {
    return {};
  },
  computed: {
    bookMeta() {
      return this.$store.state.bookMeta;
    },
  },
  methods: {
    ...mapActions(['addbookMeta']),

    addBookMetaToCart(currentBookMeta) {
      this.addbookMeta(currentBookMeta);
    },
    addCurrentbookMeta(bookMeta) {
      this.currentbookMeta(bookMeta);
    },
  },
};
</script>

<style>
.containerCard {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  grid-template-rows: repeat(auto-fill, 400px);
  column-gap: 10px;
  row-gap: 15px;
  text-align: center;
  justify-content: center;
}
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 300px;
  text-align: center;
  font-family: arial;
  margin: 50px;
}

.price {
  color: grey;
  font-size: 22px;
}

.card button {
  border: none;
  outline: 0;
  padding: 12px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
  font-size: 18px;
}

.card button:hover {
  opacity: 0.7;
}
.image {
  height: 100px;
  width: 50px;
}
</style>
