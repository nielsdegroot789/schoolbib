export default {
  getBookMeta(state, bookMeta) {
    state.bookMeta = bookMeta;
  },
  getBooks(state, data) {
    state.books = data;
  },
  getFrontpageNotification(state, data) {
    state.notification = data;
  },
  getProfileData(state, profileData) {
    state.profileData = profileData;
  },
  setNotification(state, notification) {
    state.notification = notification;
  },
};
