export const state = () => ({
  bookMeta: [],
  totalBookMeta: 0,
  books: [],
  users: [],
  currentUser: {},
  frontPageNotification: {},
  show: true,
  notifications: [],
  JWT: null,
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
  async getBookMeta({ commit, state }, filters) {
    const params = {
      limit: state.limit,
    };
    if (filters['book-name']) {
      params.title = filters['book-name'];
    }
    if (filters.pageNumber) {
      params.offset = (filters.pageNumber - 1) * state.limit;
    }
    if (filters['filter-category']) {
      params.categories = filters['filter-category'];
    }
    if (filters['filter-authors']) {
      params.authors = filters['filter-authors'];
    }

    try {
      const books = await this.$axios({
        method: 'GET',
        url: 'http://localhost:8080/getBookMeta',
        params,
      });
      commit('getBookMeta', books.data);
    } catch (error) {
      console.log(error);
    }
  },
  getBookMetaCount(context) {
    this.$axios
      .get('http://localhost:8080/getBookMetaCount')
      .then((response) =>
        context.commit('getBookMetaCount', response.data[0]['count(id)']),
      );
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
  saveBook({ state }, context, payload) {
    this.$axios
      .post('http://localhost:8080/saveBook', payload, {
        headers: { Auth: state.JWT },
      })
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
  getProfilePageData({ commit, store }, data) {
    debugger;
    console.log(data);
    this.$axios
      .get('http://localhost:8080/getProfilePageData', {
        headers: {
          Auth: store.JWT,
        },
      })
      .then((response) => commit('handleProfileData', response));
  },
  getAllUsers({ commit, state }) {
    this.$axios
      .get('http://localhost:8080/getAllUsers', {
        headers: {
          Auth: state.JWT,
        },
      })
      .then((response) => commit('setAllUsers', response.data));
  },
  openEmailModal({ commit }) {
    commit('openEmailModal');
  },
  getAdminSpecificBooks({ commit }, bookId) {
    this.$axios
      .get('http://localhost:8080/getAdminSpecificBooks', {
        headers: { Auth: localStorage.getItem('JWT') },
        params: { id: bookId },
      })
      .then((response) => commit('getAdminSpecificBooks', response.data));
  },
  deleteSpecificBook({ commit, state }) {
    const id = state.specificBook.id;
    this.$axios
      .delete('http://localhost:8080/handleSpecificBook', {
        headers: { Auth: state.JWT },
        data: { userId: id },
      })
      .then(() => commit('deleteSpecificBook', id));
  },
  setSpecificBook({ commit }, values) {
    console.log(values);
    commit('setSpecificBook', values);
  },
  toggleEditModal({ commit }, id) {
    commit('toggleEditModal', id);
  },
  toggleDeleteModal({ commit }, id) {
    commit('toggleDeleteModal', id);
  },
  deleteBatch({ commit }, batch) {
    commit('deleteBatch', batch);
  },
};

export const mutations = {
  getBookMeta(state, bookMeta) {
    state.bookMeta = bookMeta;
  },
  getBooks(state, data) {
    state.books = data;
  },
  getBookMetaCount(state, totalBookMeta) {
    state.totalBookMeta = totalBookMeta;
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
    this.$router.push('/');
    state.JWT = null;
    state.currentUser = {};
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
  toggleDeleteModal(state, id) {
    console.log(id);
    state.deleteModal = !state.deleteModal;
    state.specificBook = state.adminSpecificBooks.find(
      (book) => book.id === id,
    );
  },
};

export const getters = {
  getNotification: (state) => {
    return state.notification;
  },
  getReservation: (state) => {
    return state.reservations;
  },
  getCurrentBook: (state) => {
    return state.specificBook;
  },
};
