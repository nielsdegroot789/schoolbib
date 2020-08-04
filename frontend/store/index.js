import Vuex from 'vuex';
import axios from 'axios';

const createStore = () => {
  return new Vuex.Store({
    state: () => ({
      metaBooks: [],
      books: [],
    }),
    mutations: {
      getMetaBooks(state, data) {
        state.metaBooks = data;
      },
      getBooks(state, data) {
        state.getBooks = data;
      },
    },
    getters: {},
    actions: {
      getMetaBooks(context) {
        axios
          .get('http://localhost:8080/getMetaBooks')
          .then((response) => context.commit('getMetaBooks', response.data));
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
