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
    const array = data.split('.');
    console.log(array);
    // console.log(payload);
    // console.log(signature);

    state.header = atob(array[0]);
    state.payload = atob(array[1]);
    state.role = JSON.parse(atob(array[1])).role;
    state.signature = array[2];
  },
};
