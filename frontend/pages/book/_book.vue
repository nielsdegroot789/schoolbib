<template>
  <div class="section pageSetup">
    <div class="level box">
      <div v-if="bookMeta" class="url level-left">
        <n-link to="/">Home</n-link> > <n-link to="/books">books</n-link> >
        {{ bookMeta.title }}
      </div>
      <AddToFavoriteBook />
    </div>

    <div class="bookDetails">
      <div class="section box">
        <!-- picture  -->
        <img v-if="bookMeta" :src="bookMeta.sticker" alt="" />
      </div>
      <div class="section box">
        <!-- specifics -->
        <h1 class="title">Book Details</h1>
        <p class="level">
          <span class="level-left"> Title:</span>
          <span v-if="bookMeta" class="level-right">
            {{ bookMeta.title ? bookMeta.title : 'Unavailable' }}
          </span>
        </p>
        <p class="level">
          <span class="level-left"> Category:</span>
          <span v-if="bookMeta" class="level-right">
            {{ bookMeta.categories ? bookMeta.categories : 'Unavailable' }}
          </span>
        </p>
        <p class="level">
          <span class="level-left"> Author(s):</span>
          <span v-if="bookMeta" class="level-right">
            {{ bookMeta.authors ? bookMeta.authors : 'Unavailable' }}
          </span>
        </p>
        <p class="level">
          <span class="level-left"> Rating:</span>
          <span v-if="bookMeta" class="level-right">
            {{ bookMeta.rating ? bookMeta.rating : 'Unavailable' }}
          </span>
        </p>
        <p class="level">
          <span class="level-left"> Language:</span>
          <span v-if="bookMeta" class="level-right">
            {{ bookMeta.language ? bookMeta.language : 'Unavailable' }}
          </span>
        </p>
        <p class="level">
          <span class="level-left"> ISBN:</span>
          <span v-if="bookMeta" class="level-right">
            {{ bookMeta.isbnCode ? bookMeta.isbnCode : 'Unavailable' }}
          </span>
        </p>
        <p class="level">
          <span class="level-left"> Publishers:</span>
          <span v-if="bookMeta" class="level-right">
            {{ bookMeta.publishers ? bookMeta.publishers : 'Unavailable' }}
          </span>
        </p>
        <p class="level">
          <span class="level-left"> Publish Date:</span>
          <span v-if="bookMeta" class="level-right">
            {{ bookMeta.publishDate ? bookMeta.publishDate : 'Unavailable' }}
          </span>
        </p>
        <p class="level">
          <span class="level-left"> Reading Level:</span>
          <span v-if="bookMeta" class="level-right">
            {{ bookMeta.readingLevel ? bookMeta.readingLevel : 'Unavailable' }}
          </span>
        </p>
      </div>
      <div class="section box stockInfo">
        <h3 class="title">Interested in reading?</h3>
        <p v-if="stockCount === 0">
          There are currently no books available. Feel free to contact an
          employee.
        </p>
        <p v-else-if="stockCount === 1">
          There is currently <b> {{ istockCount }} </b> available.
        </p>
        <p v-else>
          There are currently <b> {{ stockCount }} </b> available.
        </p>
        <!-- todo change this to only show when logged in otherwise go to login -->
        <button
          class="button is-large"
          @click="
            // this is a horrible way to show notification. Unable to change it even if something goes wrong in backend
            submitReserveData();
            saveCheckoutNotif();
          "
        >
          Reserve now!
        </button>
      </div>
    </div>
    <adminEditBook />
  </div>
</template>

<script>
import adminEditBook from '~/components/AdminEditBook';
import addToFavoriteBook from '~/components/AddToFavoriteBook';
export default {
  components: {
    adminEditBook,
    addToFavoriteBook,
  },
  data() {
    return {
      timestamp: '',
      adminSpecificBooks: Array,
      bookMeta: Array,
      stockCount: '',
    };
  },
  computed: {
    // this WONT work if student opens page
    currentUserId() {
      return this.$store.state.currentUser.id;
    },
  },
  created() {},
  mounted() {
    // General page
    // route naar stock count met params van deze erbij

    this.$axios
      .get('getBookMetaFromId', {
        params: { id: this.$route.params.book },
        headers: {
          Auth: this.$store.state.JWT,
        },
      })
      .then((response) => {
        this.bookMeta = response.data[0];
      });

    this.$axios
      .get('stockCount', {
        params: { id: this.$route.params.book },
        headers: {
          Auth: localStorage.getItem('JWT'),
        },
      })
      .then((response) => {
        this.stockCount = response.data[0].count;
      });
  },

  methods: {
    submitReserveData() {
      const today = new Date();
      const reservationDateTime = today.toLocaleString('en-GB');
      const headers = {
        Auth: localStorage.getItem('JWT'),
      };
      this.$axios
        .post(
          'saveReservationsUser',
          {
            params: {
              data: this.UserId,
              booksId: this.$route.params.book,
              usersId: this.currentUserId,
              reservationDateTime,
            },
          },
          { headers },
        )
        .then(function (response) {});
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
  grid-template-columns: 20% 50% 30%;
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
