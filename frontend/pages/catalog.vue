<template>
  <div>
    <div class="topContainer">
      <input
        v-model="search"
        type="text"
        placeholder="Search on title.."
        @keydown="toSearch"
      />

      <Pagination />
    </div>
    <div class="containerCard">
      <div v-for="(item, index) in bookMeta" :key="index">
        <div class="card">
          <button class="btnAddList">&hearts;</button>
          <n-link :to="/catalog/ + /book/ + item.id">
            <div class="image">
              <img src="item.sticker" />
            </div>
            <div class="titleDiv">
              <h1>{{ item.title }}</h1>
            </div>
            <p class="rating">{{ item.rating }} / 5</p>

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
      timeoutId: null,
      filterTimeOut: null,
    };
  },
  computed: {
    changePageNumber() {
      return this.$store.getters.pageNumber;
    },
    pageNumber() {
      return parseInt(this.$route.params.page);
    },
    bookMeta() {
      return this.$store.state.bookMeta;
    },
  },

  watch: {
    $route: {
      immediate: true,
      handler(route) {
        this.search = route.query.name;
        this.$store.dispatch('getBookMeta', {
          pageNumber: this.pageNumber,
          name: this.search,
        });
        console.log(route);
      },
    },
  },
  methods: {
    toSearch() {
      clearTimeout(this.filterTimeOut);
      this.filterTimeOut = setTimeout(() => {
        this.$router.push({ path: '/catalog/', query: { name: this.search } });
      }, 1000);
      console.log('search');
    },
  },
};
</script>

<style>
.topContainer {
  display: flex;
  justify-content: space-evenly;
}
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
input[type='text'] {
  display: flex;
  width: 600px;
  justify-content: space-between;
  text-align: center;
  margin-bottom: 50px;
  height: 4rem;
  padding-left: 1rem;
  background-color: #f9f9f9;
  color: black;
  width: 700px;
  border: 0;
  border-radius: 3px;
  border-color: black;
  border-width: 0.5px;
  border-style: dotted;
  padding: 10px;
}
</style>
