import Vuex from 'vuex';
import axios from 'axios';

const createStore = () => {
  return new Vuex.Store({
    state: () => ({
      books: [],
    }),
    mutations: {
      getBooks(state, data) {
        state.books = data;
      },
    },
    getters: {},
    actions: {
      getBooks(context) {
        axios
          .get('http://localhost:8080/')
          .then((response) => context.commit('getBooks', response.data));
      },
    },
  });
};

export default createStore;
