export default {
  getBookMetaById: (state) => (id) => {
    return state.bookMeta.filter((bookMeta) => bookMeta.id === id);
  },
  getBooksByBookMetaId: (state) => (id) => {
    return state.books.filter((books) => books.bookMetaId === id);
  },
  getProfileData: (state) => {
    return state.profileData;
  },
};
