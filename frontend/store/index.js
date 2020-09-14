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
        // todo check if accessible, if not make new backend request
        return state.bookMeta.filter((bookMeta) => bookMeta.id === id);
      },
      getBooksByBookMetaId: (state) => (id) => {
        // todo check if accessible, if not make new backend request
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
      saveBook(context, payload) {
        const axiosConfig = {
          headers: {
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Headers': 'X-Requested-With',
          },
        };

        axios
          .post('http://localhost:8080/saveBook', payload, axiosConfig)
          .catch((error) => {
            console.log(error);
          });

        // .then((response) => context.commit('getBooks', response.data));
      },
      createBook(context) {
        // axios
        //   .get('http://localhost:8080/getBooks')
        //   .then((response) => context.commit('getBooks', response.data));
      },
    },
  });
};

export default createStore;
