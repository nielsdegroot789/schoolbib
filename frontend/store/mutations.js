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
  addNotification(state, notification) {
    state.notifications.push({
      ...notification,
      id: Math.random().toString(36) + Date.now().toString(36).substr(2),
    });
  },

  deleteNotification(state, notificationRemove) {
    state.notifications = state.notifications.filter((notification) => {
      return notification.id !== notificationRemove.id;
    });
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
    state.JWT = null;
    state.currentUser = {};
  },
  setTotalItems(state, payload) {
    state.setTotalItems = payload;
  },
  getReservations(state, reservation) {
    state.reservation = reservation;
  },
};
