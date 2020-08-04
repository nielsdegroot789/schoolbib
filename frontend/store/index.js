import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

window.axios = axios;

Vue.use(Vuex);

const createStore = () => {
  return new Vuex.Store({
    state: () => ({}),
    mutations: {},
  });
};

export default createStore;
