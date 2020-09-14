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

  addBookMeta(context, id) {
    context.commit('ADD_bookMeta', id);
  },

  removeBookMeta(context, index) {
    context.commit('REMOVE_bookMeta', index);
  },
  currentProduct: (context, bookMeta) => {
    context.commit('CURRENT_bookMeta', bookMeta);
  },
};
