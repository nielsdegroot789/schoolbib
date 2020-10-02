<template>
  <div>
    <searchBar />
    <frontNotification />
    <introContainer />
    <quickLinks />
    <carouselLinks />
    <Carousel />
    <Footer />
  </div>
</template>

<script>
import searchBar from '../components/SearchBar';
import Footer from '../components/Footer';
import Carousel from '../components/Carousel';
import introContainer from '../components/IntroText';
import frontNotification from '../components/frontNotification';
import quickLinks from '../components/quickLinks';
import carouselLinks from '../components/CarouselLinks';

export default {
  components: {
    searchBar,
    Footer,
    carouselLinks,
    Carousel,
    introContainer,
    frontNotification,
    quickLinks,
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
