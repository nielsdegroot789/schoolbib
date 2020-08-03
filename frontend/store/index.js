import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
import Api from '@/services/api';

window.axios = axios;

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    users: [],
    currentUser: {},
  },
  actions: {
    async loginUser({ commit }, loginInfo) {
      try {
        const response = await Api().post('/sessions', loginInfo);
        const user = response.data.data.attributes;

        commit('SET_CURRENT_USER', user);
        return user;
      } catch {
        return {
          error: 'Email/password combination was incorrect.  Please try again.',
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
