import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

const createStore = () => {
  return new Vuex.Store({
    state: () => ({
      metaBooks: [],
      books: [],
      users: [],
      currentUser: {},
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
      async loginUser({ commit }, loginInfo) {
        try {
          const response = await Api().post('/sessions', loginInfo);
          const user = response.data.data.attributes;

          commit('SET_CURRENT_USER', user);
          return user;
        } catch {
          return {
            error:
              'Email/password combination was incorrect.  Please try again.',
          };
        }
      },

      async registerUser({ commit }, registrationInfo) {
        try {
          const response = await Api().post('/users', registrationInfo);
          const user = response.data.data.attributes;

          commit('SET_CURRENT_USER', user);
          return user;
        } catch {
          return { error: 'There was an error.  Please try again.' };
        }
      },
    },
  });
};

export default createStore;
