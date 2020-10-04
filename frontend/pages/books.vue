<template>
  <div class="section pageSetup">
    <div class="section level">
      <input
        v-model="search"
        type="text"
        placeholder="Search on title.."
        class="level-left"
        @keydown="toSearch"
      />

      <Pagination class="level-right" />
    </div>

    <div class="cardContainer">
      <div v-for="item in bookMeta" :key="item.id" class="card">
        <div class="card-header noOverflow">
          <p class="card-header-title">{{ item.title }}</p>
        </div>
        <div class="card-image">
          <figure class="image is-4by5">
            <img :src="item.sticker" alt="" />
          </figure>
        </div>
        <div class="card-content"></div>
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

<style scoped>
.pageSetup {
  padding-left: 5%;
  padding-right: 5%;
}

.noOverflow {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.cardContainer {
  display: grid;
  margin: 0 auto;
  grid-template-columns: repeat(7, 13%);
  column-gap: 1%;
  row-gap: 50px;
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
