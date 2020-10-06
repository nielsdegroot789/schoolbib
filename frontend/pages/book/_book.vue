<template>
  <div class="section pageSetup">
    <div class="level box">
      <div class="url level-left">
        <n-link to="/">Home</n-link> > <n-link to="/books">books</n-link> >
        {{ bookMeta.title }}
      </div>
    </div>

    <div class="bookDetails">
      <div class="section box">
        <!-- picture  -->
        <img :src="bookMeta.sticker" alt="" />
      </div>
      <div class="section box">
        <!-- specifics -->
        <h1 class="title">Book Details</h1>
        <p class="level">
          <span class="level-left"> Title:</span>
          <span class="level-right">
            {{ bookMeta.title ? bookMeta.title : 'Unavailable' }}
          </span>
        </p>
        <p class="level">
          <span class="level-left"> Category:</span>
          <span class="level-right">
            {{ bookMeta.categories ? bookMeta.categories : 'Unavailable' }}
          </span>
        </p>
        <p class="level">
          <span class="level-left"> Author(s):</span>
          <span class="level-right">
            {{ bookMeta.authors ? bookMeta.authors : 'Unavailable' }}
          </span>
        </p>
        <p class="level">
          <span class="level-left"> Rating:</span>
          <span class="level-right">
            {{ bookMeta.rating ? bookMeta.rating : 'Unavailable' }}
          </span>
        </p>
        <p class="level">
          <span class="level-left"> Language:</span>
          <span class="level-right">
            {{ bookMeta.language ? bookMeta.language : 'Unavailable' }}
          </span>
        </p>
        <div v-if="showDetails">
          <p class="level">
            <span class="level-left"> ISBN:</span>
            <span class="level-right">
              {{ bookMeta.isbnCode ? bookMeta.isbnCode : 'Unavailable' }}
            </span>
          </p>
          <p class="level">
            <span class="level-left"> Publishers:</span>
            <span class="level-right">
              {{ bookMeta.publishers ? bookMeta.publishers : 'Unavailable' }}
            </span>
          </p>
          <p class="level">
            <span class="level-left"> Publish Date:</span>
            <span class="level-right">
              {{ bookMeta.publishDate ? bookMeta.publishDate : 'Unavailable' }}
            </span>
          </p>
          <p class="level">
            <span class="level-left"> Reading Level:</span>
            <span class="level-right">
              {{
                bookMeta.readingLevel ? bookMeta.readingLevel : 'Unavailable'
              }}
            </span>
          </p>
        </div>
        <button v-if="showDetails" class="button" @click="toggleDetails">
          Hide Details
        </button>
        <button v-if="!showDetails" class="button" @click="toggleDetails">
          Show Details
        </button>
      </div>
      <div class="section box stockInfo">
        <h3 class="title">Interested in reading?</h3>
        <p v-if="inStock === 0">
          There are currently no books available. Feel free to contact an
          employee.
        </p>
        <p v-else-if="inStock === 1">
          There is currently <b> {{ inStock }} </b> available.
        </p>
        <p v-else>
          There are currently <b> {{ inStock }} </b> available.
        </p>
        <!-- todo change this to only show when logged in otherwise go to login -->
        <button
          class="button is-large"
          @click="
            submitReserveData();
            saveCheckoutNotif();
          "
        >
          Reserve now!
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      timestamp: '',
      showDetails: false,
      inStock: 5,
    };
  },
  computed: {
    bookMeta() {
      return this.$store.getters.getBookMetaById(
        parseInt(this.$route.params.book),
      )[0];
    },
    books() {
      return this.$store.getters.getBooksByBookMetaId(
        parseInt(this.$route.params.book),
      );
    },
    currentUserId() {
      return this.$store.state.currentUser.id;
    },
  },
  mounted() {
    this.booksId = this.$route.params.books;
  },
  created() {
    this.$axios.get('http://localhost:8080/inStock').then((response) => {
      this.inStock = response.data;
    });
  },

  methods: {
    submitReserveData() {
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
      this.timestamp = dateTime.toString();

      this.$axios
        .post('http://localhost:8080/saveReservationsUser', {
          booksId: this.$route.params.book,
          usersId: this.currentUserId,
          reservationDateTime: this.timestamp,
          accepted: 0,
        })
        .then(function (response) {
          // this.saveCheckoutNotif();
        });
    },

    saveCheckoutNotif() {
      this.$store.dispatch('addNotification', {
        type: 'success',
        message: 'Form saved',
      });
    },
  },
};
</script>

<style language="scss">
.bookDetails {
  display: grid;
  grid-template-columns: 25% 40% 35%;
}

.bookDetails img {
  width: 100%;
}

.pageSetup {
  padding-left: 5%;
  padding-right: 5%;
}
.bookDetails .subtitle {
  color: black;
}

.stockInfo {
  text-align: center;
  background-color: #474c66;
  margin-bottom: 1.5rem;
  height: 50%;
  margin: 10px;
  margin-top: 7.5rem;
  color: white;
}

.stockInfo .title {
  color: white;
}

.stockInfo .button {
  margin-top: 1.5rem;
}
</style>
