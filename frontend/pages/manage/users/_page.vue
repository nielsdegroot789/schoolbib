<template>
  <div class="container">
    <div class="portfolio">
      <div v-if="!isApiReady">
        <Loading />
      </div>
      <div v-if="isApiReady" class="peopleContainer">
        <p>Specific information about students goes here</p>
      </div>
      <Pagination />
    </div>
  </div>
</template>

<script>
import Loading from '~/components/Loading';
import Pagination from '~/components/Pagination';

export default {
  components: {
    Loading,
    Pagination,
  },
  data() {
    return {
      people: Array,
      pagesCount: Number,
      isApiReady: Boolean,
    };
  },
  computed: {
    currentPage() {
      return parseInt(this.$route.params.page);
    },
  },
  methods: {},
};
</script>

<style>
.container {
  padding-top: 150px;
  background-color: lightgray;
  height: 2000px;
  display: flex;
  flex-direction: column;
}

.settings {
  display: flex;
  justify-content: center;
  align-items: center;
}

.portfolio {
  height: 90%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.peopleContainer {
  width: 90%;
  height: 90%;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-around;
  margin: auto;
  padding-top: 20px;
}

.peopleContainer .person {
  width: 23%;
  height: 15%;
  border: black thin solid;
  margin: 2px;
  padding: 5px;
}

.peopleContainer .person .img {
  float: right;
}

.peopleContainer .person img {
  height: 100px;
}

.buttonContainer {
  bottom: 15px;
  width: 100%;
  padding: 0 35%;
}

.pageContainer {
  display: flex;
  justify-content: center;
  margin: 0 100px;

  width: 200px;
  position: absolute;
  left: 50%;
  margin-left: -100px;
}
button {
  margin: 0 5px;
}

.highlighted {
  background-color: goldenrod;
}

.left {
  float: left;
}

.right {
  float: right;
}
</style>
