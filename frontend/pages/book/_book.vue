<template>
  <div class="PageContainer">
    <div v-for="(bookMeta, index) in bookMeta" :key="index">
      <div v-for="(book, index) in books" :key="index">
        <div class="BookInfoContainer">
          <div class="InfoAboveBook">
            <n-link to="/">Home</n-link> >
            <n-link to="/catalog">catalog</n-link> > {{ bookMeta.title }}
            {{ book.stock }}
          </div>
          <div class="containerBook">
            <div class="containerBookAbove">
              <img
                v-img
                src="./book.png"
                alt="bookPic"
                height="50px"
                width="50px"
              />
              <h3>book</h3>
              {{ bookMeta.language }}
            </div>
            <div class="containerBookInfo">
              <div class="containerBookInfoLeft">
                <div>{{ bookMeta.sticker }}</div>
                <Button @click="addTofavoriteBooks">
                  &#10084; Place on list
                </Button>
              </div>
              <div class="containerBookInfoMiddle">
                <h1>{{ bookMeta.title }}</h1>
                <!-- <h3>{{ authors.name }} {author}</h3> -->
                <!-- <h3>Genre: {{ catagory.name }}</h3> -->
                <h5>amount in stock : {{ book.stock }}</h5>

                <p>the different versions:</p>
                <div v-for="(book, index) in books" :key="index">
                  {{ book.status }} Drolhoofd
                </div>
              </div>
              <div v-if="book.stock != 0" class="containerBookInfoRight">
                <button @click="LendBook">Lend here!</button>
              </div>
              <div v-else class="containerBookInfoRight">
                This book isn't in the store anymore.
                <button @click="reserve">reserve here!</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      bookId: 0,
      bookData: [],
    };
  },
  computed: {
    bookMeta() {
      return this.$store.getters.getBookMetaById(
        parseInt(this.$route.params.book),
      );
    },
    books() {
      return this.$store.getters.getBooksByBookMetaId(
        parseInt(this.$route.params.book),
      );
    },
  },
  mounted() {
    this.bookId = this.$route.params.book;
  },
  methods: {},
};
</script>

<style>
.BookInfoContainer {
  height: 400px;
}
.PageContainer {
  margin: 50px;
}
.InfoAboveBook {
  border-color: rgb(93, 93, 93);
  background-color: rgb(198, 194, 194);
  border: 1px solid #dbdbdb;
  border-radius: 6px;
  padding: 10px;
}
.containerBookAbove {
  border-color: rgb(93, 93, 93);
  background-color: rgb(198, 194, 194);
  border: 1px solid #dbdbdb;
  border-radius: 6px;
  padding: 50px;
  margin-top: 50px;
}
.containerBook {
  background: rgb(235, 235, 235);
  height: 800px;
  display: block;
  padding: 30px;
}
.containerBookInfo {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  justify-content: left;
  background: rgb(209, 190, 183);
  height: 600px;
  padding: 30px;
}
.containerBookInfoLeft {
  background: honeydew;
  padding: 30px;
  margin-right: 100px;
  align-content: center;
  justify-content: center;
}
.containerBookInfoMiddle {
  background: honeydew;
  margin-right: 100px;
  align-content: center;
  justify-content: center;
}
.containerBookInfoMiddle > *,
.containerBookInfoLeft > *,
.containerBookInfoRight > * {
  text-align: center;
}
.containerBookInfoRight {
  background: honeydew;
  margin-right: 100px;
  align-content: center;
  justify-content: center;
}
</style>
