export default {
  getBookMeta(state, bookMeta) {
    state.bookMeta = bookMeta;
  },
  getBooks(state, data) {
    state.books = data;
  },
  getNotification(state, data) {
    state.notification = data;
  },
  setTotalItems(state, payload) {
    state.setTotalItems = payload;
  },
  getReservations(state, reservation) {
    state.reservation = reservation;
  },
};
