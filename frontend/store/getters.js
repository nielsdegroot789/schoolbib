export default {
  getBookMetaById: (state) => (id) => {
    return state.bookMeta.filter((bookMeta) => bookMeta.id === id);
  },
  getBooksByBookMetaId: (state) => (id) => {
    return state.books.filter((books) => books.bookMetaId === id);
  },
  getBookMetaInCart: (state) => state.cartBookMeta,

  getCurrentBookMeta: (state) => state.currentBookMeta,
};
