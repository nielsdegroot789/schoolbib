export default {
  getBookMetaById: (state) => (id) => {
    return state.bookMeta.filter((bookMeta) => bookMeta.id === id);
  },
  getBooksByBookMetaId: (state) => (id) => {
    return state.books.filter((books) => books.bookMetaId === id);
  },
  getPageCount(state) {
    return Math.ceil(state.totalItems / state.limit);
  },
  getBookMetaCount: (state) => (count) => {
    return state.bookMeta.filter((bookMeta) => bookMeta.count === count);
  },
};
