<template>
  <div>
    <searchBar />
    <introContainer />
    <Carousel />
    <Footer />
  </div>
</template>

<script>
import searchBar from '../components/SearchBar';
import Footer from '../components/Footer';
import Carousel from '../components/Carousel';
import introContainer from '../components/IntroText';

export default {
  components: {
    searchBar,
    Footer,
    Carousel,
    introContainer,
  },

  data: () => {
    return {};
  },
};
</script>

<style>
html {
  font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, 'Segoe UI',
    Roboto, 'Helvetica Neue', Arial, sans-serif;
  font-size: 16px;
  word-spacing: 1px;
  -ms-text-size-adjust: 100%;
  -webkit-text-size-adjust: 100%;
  -moz-osx-font-smoothing: grayscale;
  -webkit-font-smoothing: antialiased;
  box-sizing: border-box;
}
</style>
