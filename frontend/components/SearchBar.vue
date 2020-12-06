<template>
  <div class="wrapper">
    <div class="container">
      <div class="inner-wrapper">
        <Search />
      </div>
    </div>
  </div>
</template>

<script>
import Search from '../components/Filters';
export default {
  name: 'SearchBar',
  components: {
    Search,
  },
};
</script>

<style></style>
