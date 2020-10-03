import axios from 'axios';
export const state = {
  bookMeta: [],
  books: [],
  users: [],
  currentUser: [],
  frontPageNotification: {},
  show: true,
  notifications: [],
  JWT: null,
  showLoginError: false,
  limit: 20,
  reservations: [],
};

export const getters = {
  getBookMetaById: (state) => (id) => {
    return state.bookMeta.filter((bookMeta) => bookMeta.id === id);
  },
  getBooksByBookMetaId: (state) => (id) => {
    return state.books.filter((books) => books.bookMetaId === id);
  },
  getNotification: (state) => {
    return state.notification;
  },
  getReservations: (state) => {
    return state.reservations;
  },
  getPageCount(state) {
    return Math.ceil(state.totalItems / state.limit);
  },
  getBookMetaCount: (state) => (count) => {
    return state.bookMeta.filter((bookMeta) => bookMeta.count === count);
  },
  getReservationsById: (state) => (id) => {
    return state.reservations.filter((reservations) => reservations.id === id);
  },
};

export const mutations = {
  getBookMeta(state, bookMeta) {
    state.bookMeta = bookMeta;
  },
  getBooks(state, data) {
    state.books = data;
  },
  getReservations(state, reservations) {
    state.reservations = reservations;
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
};

export const actions = {
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
  },
  getReservations(context) {
    axios
      .get('http://localhost:8080/getReservations')
      .then((response) => context.commit('getReservations', response.data));
  },
};
