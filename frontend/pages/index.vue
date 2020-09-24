<template>
  <div>
    <SearchBar />
    <FrontNotification />
    <IntroContainer />
    <QuickLinks />
    <CarouselLinks />
    <Carousel />
    <Footer />
  </div>
</template>

<script>
import SearchBar from '../components/SearchBar';
import Footer from '../components/Footer';
import Carousel from '../components/Carousel';
import IntroContainer from '../components/IntroText';
import FrontNotification from '../components/frontNotification';
import QuickLinks from '../components/QuickLinks';
import CarouselLinks from '../components/CarouselLinks';

export default {
  components: {
    SearchBar,
    Footer,
    CarouselLinks,
    Carousel,
    IntroContainer,
    FrontNotification,
    QuickLinks,
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
