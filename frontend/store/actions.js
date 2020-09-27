import axios from 'axios';

export default {
  getBookMeta(context) {
    axios
      .get('http://localhost:8080/getBookMeta', {
        headers: { Authorization: `Bearer test` },
      })
      .then((response) => context.commit('getBookMeta', response.data));
  },
  getBooks(context) {
    axios
      .get('http://localhost:8080/getBooks')
      .then((response) => context.commit('getBooks', response.data));
  },
  getNotification(context) {
    axios
      .get('http://localhost:8080/getNotification')
      .then((response) => context.commit('getNotification', response.data));
  },
  saveBook(context, payload) {
    axios.post('http://localhost:8080/saveBook', payload).catch((error) => {
      console.log(error);
    });
  },
  login(context, payload) {
    axios
      .post('http://localhost:8080/login', payload)
      .then((response) => {
        localStorage.setItem('JWT', response.data);
        context.commit('setJWTtoken', response.data);
      })
      .then((response) => {
        this.$router.push('/');
      })
      .catch((error) => {
        // todo Show error messages
        context.commit('setLoginError');
        console.log(error);
      });
  },
  getBookFromGoogleAPI(context) {
    // https://www.googleapis.com/books/v1/volumes?q=isbn:9780553213102&key=AIzaSyBFgcdVYDuw2EzuxaaUQZ45PMZw8Q5ksxs
    axios({
      method: 'GET',
      url: 'https://www.googleapis.com/books/v1/volumes',
      params: {
        q: '',
        isbn: '9780553213102',
        key: 'AIzaSyBFgcdVYDuw2EzuxaaUQZ45PMZw8Q5ksxs',
      },
    })
      .then((response) => {
        console.log(response);
        debugger;
      })
      .catch((error) => {
        console.log(error);
      });
  },
};
