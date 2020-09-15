<template>
  <div>
    <input v-model="search" type="text" placeholder="Search on title.." />

    <div class="containerCard">
      <div v-for="(item, index) in filteredMetaBooks" :key="index">
        <div class="card">
          <button class="btnAddList">&hearts;</button>
          <n-link :to="/book/ + item.id">
            <div class="image">
              <img src="item.sticker" />
            </div>
            <div class="titleDiv">
              <h1>{{ item.title }} booktitle</h1>
            </div>
            <p class="rating">4/5</p>

            <p>
              {{ item.description }}
            </p>

            <button class="borrow">Borrow</button>
          </n-link>
        </div>
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
.btnAddList {
  float: left;
}
.titleDiv {
  display: flex;
  height: 50px;
  text-align: center;
  justify-content: center;
}
.containerCard {
  width: 90%;
  display: grid;
  margin: 0 auto;
  grid-template-columns: 1fr 1fr 1fr 1fr;
  grid-auto-rows: 400px;
  column-gap: 100px;
  row-gap: 50px;
}
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 300px;
  text-align: center;
  font-family: arial;
}

.rating {
  color: grey;
  font-size: 22px;
}

.borrow {
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

.borrow:hover {
  opacity: 0.7;
}
.image {
  height: 150px;
  width: 50px;
}
</style>
