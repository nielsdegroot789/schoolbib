import axios from 'axios';

export default {
  getBookMeta(context) {
    axios
      .get('http://localhost:8080/getBookMeta')
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
  GetReservations(context) {
    axios
      .get('http://localhost:8080/GetReservations')
      .then((response) => context.commit('GetReservations', response.data));
  },
};
