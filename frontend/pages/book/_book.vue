<template>
  <div class="container">
    <div class="travelContainer">
      <div class="elementContainer bold">
        <span>title</span>
        <span>isbn</span>
        <span>publishDate</span>
        <span>rating</span>
        <span>totalPages</span>
        <span>sticker</span>
        <span>language</span>
        <span>readingLevel</span>
        <span>authors</span>
        <span>publishers</span>
        <span>status</span>
        <span>stock</span>
        <span>authorsId</span>
        <span>categories</span>
      </div>

      <div v-for="(item, index) in books" :key="index" class="elementContainer">
        <span>{{ item.title }}</span>
        <span>{{ item.isbn }}</span>
        <span>{{ item.publishDate }}</span>
        <span>{{ item.rating }}</span>
        <span>{{ item.totalPages }}</span>
        <span>{{ item.sticker }}</span>
        <!-- //cover? -->
        <span>{{ item.language }}</span>
        <span>{{ item.readingLevel }}</span>
        <span>{{ item.authors }}</span>
        <span>{{ item.publishers }}</span>
        <span>{{ item.status }}</span>
        <span>{{ item.stock }}</span>
        <span>{{ item.authorsId }}</span>
        <span>{{ item.categories }}</span>

        <!-- <router-link :to="{ path: '/edit/' + item.id }">
          <font-awesome-icon :icon="['fas', 'edit']" />
        </router-link>

        <div @click="deleteItem(item.id)">
          <font-awesome-icon :icon="['fas', 'trash-alt']" />
        </div> -->
      </div>
    </div>
    <!-- <router-link to="/NewForm">
      <font-awesome-icon class="addNewButton" :icon="['fas', 'plus-square']" />
    </router-link> -->
  </div>
</template>

<script>
import axios from 'axios';
export default {
  data() {
    return {
      books: ['test'],
    };
  },
  mounted() {
    axios
      .get('http://localhost:8080/')
      .then((response) => (this.books = response.data));
  },
};
</script>

<style>
.container {
  margin: 0 auto;
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
}

.title {
  font-family: 'Quicksand', 'Source Sans Pro', -apple-system, BlinkMacSystemFont,
    'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
  display: block;
  font-weight: 300;
  font-size: 100px;
  color: #35495e;
  letter-spacing: 1px;
}

.subtitle {
  font-weight: 300;
  font-size: 42px;
  color: #526488;
  word-spacing: 5px;
  padding-bottom: 15px;
}

.links {
  padding-top: 15px;
}

.travelContainer {
  width: 100%;
}

.travelContainer > :nth-child(odd) {
  background-color: lightgray;
}

.elementContainer {
  display: grid;
  grid-template-columns: repeat(14, calc(100% / 14));
  justify-items: center;
  align-items: center;
  margin: 5px 0;
}
</style>
