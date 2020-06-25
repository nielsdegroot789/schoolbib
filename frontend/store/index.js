import Vuex from 'vuex';

const createStore = () => {
  return new Vuex.Store({
    state: () => ({
      title: 'A title',
    }),
    mutations: {},
    getters: {},
    actions: {},
  });
};

export default createStore;
