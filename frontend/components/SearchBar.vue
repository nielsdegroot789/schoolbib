<template>
  <div class="wrapper">
    <div class="container">
      <div class="inner-wrapper">
        <input type="text" class="search" placeholder="Enter your search" />
        <button class="searchButton">
          <font-awesome-icon :icon="['fas', 'search']" />
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SearchBar',
};
</script>

<style></style>
