<template>
  <div class="section pageSetup">
    <div class="level box nav-admin--edit">
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
      <div class="section box flex-container-book--admin-edit">
        <div class="section box book-info--admin-edit">
          <!-- specifics -->
          <h1 class="title">
            {{ bookMeta.title ? bookMeta.title : 'Unavailable' }}
          </h1>
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
              {{
                bookMeta.readingLevel ? bookMeta.readingLevel : 'Unavailable'
              }}
            </span>
          </p>
        </div>
        <div class="section box stockInfo">
          <h3 class="title">Interested in reading?</h3>
          <p v-if="stockCount === 0">
            There are currently no books available. Feel free to contact an
            employee.
          </p>
          <p v-else-if="stockCount === 1" class="stock-p--admin-edit">
            There is currently <b> {{ stockCount }} </b> available.
          </p>
          <p v-else class="stock-p--admin-edit">
            There are currently <b> {{ stockCount }} </b> available.
          </p>
          <button
            class="button is-large button-reserve--admin-edit"
            @click="submitReserveData()"
          >
            Reserve now!
          </button>
        </div>
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
  mounted() {
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
        .then(function (response) {
          this.saveCheckoutNotif();
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
  grid-template-columns: 20% 80%;
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
  background-color: #28528a;
  height: 50%;
  margin: 1rem;
  margin-top: 0;
  color: white;
}

.stockInfo .title {
  color: white;
}

.stockInfo .button {
  margin-top: 1.5rem;
}

.nav-admin--edit {
  box-shadow: none;
}
.button-reserve--admin-edit {
  background-color: #3369b2;
  border: none;
  color: white;
}
.button-reserve--admin-edit:hover {
  background-color: white;
  color: black;
}
.stock-p--admin-edit {
  text-decoration: underline;
}
.flex-container-book--admin-edit {
  display: flex;
  justify-content: space-evenly;
  margin-bottom: 1.5rem;
}
.book-info--admin-edit {
  min-width: 533px;
  box-shadow: none;
  margin-top: 0;
  padding-top: 0;
}
</style>
