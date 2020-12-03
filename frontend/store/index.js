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
  autoCompleteResults: [],
  categoryList: [],
  authorList: [],
  titleList: [],
  batches: [],
  isAdmin: false,
  isStudent: false,
});

export const actions = {
  async getBookMeta({ commit }, { filters }) {
    const params = {};
    if (filters['book-name']) {
      params.title = filters['book-name'];
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
        headers: { Authorization: `Bearer test` },
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
      .then((response) => context.commit('getBookMetaCount', response.data));
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
  deleteSpecificBook({ commit, state }) {
    const id = state.specificBook.id;
    this.$axios
      .delete('http://localhost:8080/handleSpecificBook', {
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
  getAutoCompleteResults({ commit }, search) {
    if (search.length === 0) {
      return commit('makeEmpty');
    }
    const params = {
      searchVal: search,
    };
    this.$axios({
      method: 'GET',
      url: 'http://localhost:8080/getFilterResults',
      params,
    }).then((response) => {
      commit('setAutoCompleteResults', response.data);
    });
  },
  addBatch({ commit }, batch) {
    commit('setBatch', batch);
  },
  deleteBatch({ commit }, batch) {
    console.log(batch);
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
  isAdmin: (state) => {
    state.isAdmin = true;
  },
  isStudent: (state) => {
    state.isStudent = true;
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
  CheckUserRole(state) {
    switch (state.currentRole) {
      case 1:
        state.isStudent = true;
        break;
      case 2:
        state.isAdmin = true;
        break;
    }
    return false;
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
  setAutoCompleteResults(state, data) {
    state.authorList = data.filter((result) => {
      return result.type === 'authors';
    });
    state.categoryList = data.filter((result) => {
      return result.type === 'categories';
    });
    state.titleList = data.filter((result) => {
      return result.type === 'title';
    });
  },
  makeEmpty(state) {
    state.categoryList = '';
    state.authorList = '';
  },
  setBatch(state, batch) {
    state.batches.push(batch);
  },
  deleteBatch(state, batch) {
    state.batches = state.batches.filter((item) => {
      return item.value !== batch;
    });
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
  getReservation: (state) => {
    return state.reservations;
  },
  getCurrentBook: (state) => {
    return state.specificBook;
  },
  getPageCount(state) {
    return Math.ceil(state.totalBookMeta / state.limit);
  },
};
