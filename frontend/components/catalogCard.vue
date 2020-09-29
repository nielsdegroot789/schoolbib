<template>
  <div>
    <div>
      <img:src ="product.image" alt />
      <div class="card-body">
        <h4 class="card-title">
          <router-link :to="{ name: 'books', params: { id: bookMeta.id } }">{{
            bookMeta.title
          }}</router-link>
        </h4>
        <strong>${{ bookMeta.price }}</strong>
        <p class="card-text">{{ bookMeta.description }}</p>
      </div>
      <div>
        <button @click="addToCart()">Add to Cart</button>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions } from 'vuex';
export default {
  props: ['bookMeta'],
  methods: {
    ...mapActions('cart', ['addProductToCart']),
    addToCart() {
      this.addProductToCart({
        product: this.product,
        quantity: 1,
      });
    },
  },
};
</script>

<style></style>
