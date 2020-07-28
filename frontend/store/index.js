import Vue from 'vue';
import Vuex from 'vuex';
import Api from '@/services/api';

Vue.use(Vuex);

const createStore = () => {
  return new Vuex.Store({
    state: () => ({
      title: 'A title',
      users: [],
      currentUser: {name:EersteProbeersel}
    }),
    mutations: {
      SET_USERS(state, users) {
        state.users = users;
      },
    },
    getters: {},
    actions: {
      async loadUsers({ commit }) {
        const response = await Api().get('/users');
        const users = response.data.data;
        commit(
          'SET_USERS',
          users.map((v) => v.attributes),
        );
      },
    },
  });
};

export default createStore;
