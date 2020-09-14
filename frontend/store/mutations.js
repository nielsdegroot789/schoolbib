export default {
  getBookMeta(state, bookMeta) {
    state.bookMeta = bookMeta;
  },
  getBooks(state, data) {
    state.books = data;
  },
  ADD_bookMeta: (state, product) => {
    state.cartProducts.push(product);
  },
  REMOVE_bookMeta: (state, index) => {
    state.cartProducts.splice(index, 1);
  },
  CURRENT_bookMeta: (state, bookMeta) => {
    state.currentbookMeta = bookMeta;
  },
};
