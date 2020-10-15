export const state = () => ({
  bookMeta: [],
  books: [],
  users: [],
  currentUser: {},
  frontPageNotification: {},
  show: true,
  notifications: [],
  JWT: {},
  showLoginError: false,
  limit: 20,
  reservation: [],
  profilePageData: {},
  getUsers: {},
  emailModal: false,
  adminSpecificBooks: {},
  specificBook: {},
  editModal: false,
  deleteModal: false,
});

export const actions = {
  getBookMeta(context) {
    this.$axios
      .get('http://localhost:8080/getBookMeta', {
        headers: { Authorization: `Bearer test` },
      })
      .then((response) => context.commit('getBookMeta', response.data));
  },
  getBooks(context) {
    this.$axios
      .get('http://localhost:8080/getBooks')
      .then((response) => context.commit('getBooks', response.data));
  },
  getFrontPageNotification(context) {
    this.$axios
      .get('http://localhost:8080/getNotification')
      .then((response) =>
        context.commit('getFrontPageNotification', response.data),
      );
  },
  saveBook(context, payload) {
    this.$axios
      .post('http://localhost:8080/saveBook', payload)
      .catch((error) => {
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
    this.$axios
      .post('http://localhost:8080/login', payload)
      .then((response) => {
        localStorage.setItem('JWT', response.data);
        context.commit('setJWTtoken', response.data);
      })
      .then((response) => {
        this.$router.push('/');
      })
      .catch((error) => {
        context.commit('showLoginError');
        setTimeout(() => {
          context.commit('removeLoginError');
        }, 3000);
        console.log(error);
      });
  },
  getReservation(context) {
    this.$axios
      .get('http://localhost:8080/getReservation')
      .then((response) => context.commit('getReservation', response.data));
  },
  getProfilePageData({ commit }, data) {
    console.log(data);
    this.$axios
      .get('http://localhost:8080/getProfilePageData', {})
      .then((response) => commit('handleProfileData', response));
  },
  getAllUsers({ commit }) {
    this.$axios
      .get('http://localhost:8080/getAllUsers')
      .then((response) => commit('setAllUsers', response.data));
  },
  openEmailModal({ commit }) {
    commit('openEmailModal');
  },
  getAdminSpecificBooks({ commit }, bookId) {
    this.$axios
      .get('http://localhost:8080/getAdminSpecificBooks', {
        params: { id: bookId },
      })
      .then((response) => commit('getAdminSpecificBooks', response.data));
  },
  deleteSpecificBook({ commit }, id) {
    this.$axios.delete('http://localhost:8080/handleSpecificBook', {
      data: { userId: id },
    });
    commit('deleteSpecificBook', id);
  },
  setSpecificBook({ commit }, values) {
    console.log(values);
    commit('setSpecificBook', values);
  },
  toggleEditModal({ commit }, id) {
    commit('toggleEditModal', id);
  },
  toggleDeleteModal({ commit }) {
    commit('toggleDeleteModal');
  },
};

export const mutations = {
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
  showLoginError(state) {
    state.showLoginError = true;
  },
  removeLoginError(state) {
    state.showLoginError = false;
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
  handleProfileData(state, payload) {
    state.profilePageData = payload;
  },
  setAllUsers(state, payload) {
    state.getUsers = payload;
  },
  openEmailModal(state) {
    if (!state.emailModal) {
      state.emailModal = true;
    } else {
      state.emailModal = false;
    }
  },
  getAdminSpecificBooks(state, payload) {
    state.adminSpecificBooks = payload;
  },
  deleteSpecificBook(state, removeId) {
    state.adminSpecificBooks = state.adminSpecificBooks.filter((item) => {
      return item.id !== removeId;
    });
  },
  setSpecificBook(state, values) {
    state.specificBook = values;
  },
  toggleEditModal(state, id) {
    state.editModal = !state.editModal;
    state.specificBook = state.adminSpecificBooks.find(
      (book) => book.id === id,
    );
  },
  toggleDeleteModal(state) {
    state.deleteModal = !state.deleteModal;
  },
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
  getPageCount(state) {
    return Math.ceil(state.totalItems / state.limit);
  },
  getBookMetaCount: (state) => (count) => {
    return state.bookMeta.filter((bookMeta) => bookMeta.count === count);
  },
  getReservation: (state) => {
    return state.reservations;
  },
};
