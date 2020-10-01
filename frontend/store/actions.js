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
  getFrontPageNotification(context) {
    axios
      .get('http://localhost:8080/getNotification')
      .then((response) =>
        context.commit('getFrontPageNotification', response.data),
      );
  },
  saveBook(context, payload) {
    axios.post('http://localhost:8080/saveBook', payload).catch((error) => {
      console.log(error);
    });
  },
  addNotification({ commit }, message) {
    commit('addNotification', message);
  },

  deleteNotification({ commit }, message) {
    commit('deleteNotification', message);
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
  getReservation(context) {
    axios
      .get('http://localhost:8080/getReservation')
      .then((response) => context.commit('getReservation', response.data));
  },
};
