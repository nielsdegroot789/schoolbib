export default {
  getBookMeta(state, bookMeta) {
    state.bookMeta = bookMeta;
  },
  getBooks(state, data) {
    state.books = data;
  },
  getFrontPageNotification(state, data) {
    state.frontPageNotification = data;
  },
  setNotification(state, notification) {
    state.notification = notification;
  },
  showNotification(state) {
    state.show = true;
  },
  deleteNotification(state) {
    state.show = false;
  },
};
