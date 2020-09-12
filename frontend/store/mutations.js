export default {
  getBookMeta(state, bookMeta) {
    state.bookMeta = bookMeta;
  },
  getBooks(state, data) {
    state.books = data;
  },

  ADD_Item(state, id) {
    state.StoreCart.push(id);
  },

  REMOVE_Item(state, index) {
    state.StoreCart.splice(index, 1);
  },
};
