<template>
  <div>
    <input v-model="search" type="text" placeholder="Search on title.." />
    <div class="containerCard">
      <div v-for="(item, index) in bookMeta" :key="index">
        <n-link :to="/book/ + item.id">
          <div class="card">
            <div class="image">
              <img src="item.sticker" />
            </div>
            <h1>{{ item.title }} booktitle</h1>
            <p class="price">4/5</p>

            <p>
              {{ item.description }}
            </p>
            <button>Borrow</button>
          </div>
        </n-link>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      search: '',
    };
  },
  computed: {
    bookMeta() {
      return this.$store.state.bookMeta;
    },
    filteredMetaBooks() {
      return this.bookMeta.filter((item) => item.title.includes(this.search));
    },
  },
};
</script>

<style>
.containerCard {
  width: 90%;
  display: grid;
  margin: 0 auto;
  grid-template-columns: 1fr 1fr 1fr 1fr;
  grid-auto-rows: 400px;
  column-gap: 10px;
  row-gap: 15px;
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
  height: 150px;
  width: 50px;
}
</style>
