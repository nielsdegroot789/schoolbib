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
  setJWTtoken(state, data) {
    debugger;
    state.JWT = data;
  },
};
