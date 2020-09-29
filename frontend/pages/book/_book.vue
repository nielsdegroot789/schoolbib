<template>
  <div class="PageContainer">
    <div v-for="bookMeta in bookMeta" :key="bookMeta.id">
      <div v-for="item in books" :key="item.id">
        <div class="BookInfoContainer">
          <div class="InfoAboveBook">
            <n-link to="/">Home</n-link> >
            <n-link to="/catalog">catalog</n-link> >
            {{ bookMeta.title }}
          </div>
          <div class="containerBook">
            <div class="containerBookAbove">
              <div>
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
              <div>
                <Button method="post" class="reserveBook" @click="submitData">
                  Reserve Now!
                </Button>
              </div>
            </div>

            <div class="containerBookInfo">
              <div class="containerBookInfoLeft">
                <strong>
                  <h1>{{ bookMeta.title }}</h1></strong
                >
                <div>{{ bookMeta.sticker }}</div>
                <Button @click="addTofavoriteBooks">
                  &#10084; Place on list
                </Button>
              </div>
              <div class="containerBookInfoMiddle">
                <br />

                <p>Details:</p>
                <div v-for="book in books" :key="book.id">
                  <p><strong> Title : </strong>{{ bookMeta.title }}</p>
                  <p><strong> Author :</strong> {{ bookMeta.authors }}</p>
                  <p><strong> Language(s) :</strong> {{ bookMeta.language }}</p>
                  <br />
                  <p><strong>Categorie(s)</strong> {{ bookMeta.categories }}</p>
                  <br />
                  <p>-------</p>
                  <br />
                  <p><strong>rating :</strong>{{ bookMeta.rating }} / 5</p>
                  <p><strong> Title : </strong>{{ bookMeta.title }}</p>
                  <p>
                    <strong> ReadingLevel : </strong>{{ bookMeta.readingLevel }}
                  </p>
                  <p>
                    <strong> totalPages : </strong>{{ bookMeta.totalPages }}
                  </p>
                  <p>
                    <strong> publishers : </strong>{{ bookMeta.publishers }}
                  </p>
                  <p>
                    <strong> publishDate : </strong>{{ bookMeta.publishDate }}
                  </p>
                </div>
                <!-- <div v-if="book.stock != 0" class="containerBookInfoRight">
                  <n-link to="/borrow/">
                    <button>reserve here!</button>
                  </n-link>
                </div> -->
                <!-- <div v-else class="containerBookInfoRight">
                  This book isn't in the store anymore.
                  <n-link to="/borrow/">
                    <button>reserve here!</button>
                  </n-link>
                </div> -->
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
      bookData: {},
      timestamp: '',
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
  created() {
    console.log(this.bookMeta);
    setInterval(this.getNow, 1000);
  },
  submitData() {
    axios.post('userController.php', {
      action: 'insert',
      bookId: this.book.id,
      reservationDateTime: this.getNow,
    });
  },
  methods: {
    getNow() {
      const today = new Date();
      const date =
        today.getFullYear() +
        '-' +
        (today.getMonth() + 1) +
        '-' +
        today.getDate();
      const time =
        today.getHours() + ':' + today.getMinutes() + ':' + today.getSeconds();
      const dateTime = date + ' ' + time;
      this.timestamp = dateTime;
    },
  },
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
  display: flex;
  justify-content: space-evenly;
  border-color: rgb(93, 93, 93);
  background-color: rgb(198, 194, 194);
  border: 1px solid #dbdbdb;
  border-radius: 6px;
  padding: 50px;
  margin-top: 50px;
}
.reserveBook {
  background-color: black;
  color: white;
  border-radius: 25%;
  cursor: pointer;
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
  justify-content: center;
  background: rgb(209, 190, 183);
  height: 600px;
  padding: 10px;
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
