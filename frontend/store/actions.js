import axios from 'axios';

export default {
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

  addItem(context, id) {
    context.commit('ADD_Item', id);
  },

  removeItem(context, index) {
    context.commit('REMOVE_Item', index);
  },
};
