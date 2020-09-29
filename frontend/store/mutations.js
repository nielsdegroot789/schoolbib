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
    state.JWT = data;

    const array = data.split('.');
    state.currentUser.header = atob(array[0]);
    state.currentUser.payload = atob(array[1]);
    state.currentUser.id = JSON.parse(atob(array[1])).userId;
    state.currentUser.role = JSON.parse(atob(array[1])).role;
    state.currentUser.signature = array[2];
  },
  setLoginError(state) {
    state.showLoginError = true;
    setTimeout(function () {
      state.showLoginError = false;
    }, 3000);
  },
  logout(state) {
    debugger;
    state.JWT = null;
    state.currentUser = {};
  },
};
