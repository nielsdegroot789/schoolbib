// import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

const createStore = () => {
  return new Vuex.Store({
    state: () => ({
      bookMeta: [],
      books: [],
      users: [],
      currentUser: {},
    }),
    mutations: {
      getBookMeta(state, data) {
        state.bookMeta = data;
      },
      getBooks(state, data) {
        state.books = data;
      },
    },
    getters: {
      getBookMetaById: (state) => (id) => {
        return state.bookMeta.filter((bookMeta) => bookMeta.id === id);
      },
      getBooksByBookMetaId: (state) => (id) => {
        return state.books.filter((books) => books.bookMetaId === id);
      },
    },
    actions: {
      getBookMeta(context) {
        axios
          .get('http://localhost:8080/getBookMeta')
          .then((response) => context.commit('getBookMeta', response.data));
      },
      getBooks(context) {
        axios
          .get('http://localhost:8080/getBooks')
          .then((response) => context.commit('getBooks', response.data));
      },
    },
  });
};

export default createStore;
