import Vuex from 'vuex';

const createStore = () => {
  return new Vuex.Store({
    state: () => ({
      books: [],
    }),
    mutations: {},
    getters: {},
    actions: {},
  });
};

export default createStore;
