<template>
  <div class="c-autocomplete">
    <div
      v-if="batches.length && this.$route.path == '/books'"
      class="c-autocomplete__batch-container"
    >
      <button
        v-for="item in batches"
        :key="item.value"
        class="c-autocomplete__batch"
        @click="deleteBatch(item.value, item.type)"
      >
        {{ item.type + ' : ' + item.value }}
        <font-awesome-icon class="close-icon" :icon="['fas', 'times']" />
      </button>
    </div>
    <input
      v-model="label"
      placeholder="Type your search here"
      class="c-autocomplete__input"
      type="text"
      @keyup="manualChange"
    />
    <div
      v-if="titles.length || categories.length || authors.length"
      class="autocomplete-results-container"
    >
      <h1 v-if="titles.length" class="autocomplete-title">Title</h1>
      <nuxt-link
        v-for="result in titles"
        :key="result.id"
        :to="'/book/' + result.id"
        class="auto-complete-button"
      >
        {{ result.name }}
      </nuxt-link>
      <h1 v-if="categories.length" class="autocomplete-title">Categories</h1>
      <li
        v-for="result in categories"
        :key="result.id"
        class="auto-complete-button"
        @click="emitSelect(result.name, result.type)"
      >
        {{ result.name }}
      </li>
      <h1 v-if="authors.length" class="autocomplete-title">Authors</h1>
      <li
        v-for="result in authors"
        :key="result.id"
        class="auto-complete-button"
        @click="emitSelect(result.name, result.type)"
      >
        {{ result.name }}
      </li>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Autocomplete',
  props: {
    titles: {
      required: false,
    },
    authors: {
      required: false,
    },
    categories: {
      required: false,
    },
    batches: {
      required: false,
    },
  },
  data() {
    return {
      label: '',
      timeout: null,
      authorList: '',
      titleList: '',
      categoryList: '',
    };
  },
  computed: {
    isDisabled() {
      return this.disabled;
    },
  },
  methods: {
    manualChange() {
      clearTimeout(this.timeout);
      this.timeout = setTimeout(this.loadResults, 1000);
    },
    loadResults() {
      this.$emit('loadResults', this.label);
    },
    emitSelect(val, typ) {
      this.$emit('select', { val, typ });
    },
    reloadBatch(batch) {
      this.batches.push(batch);
    },
    deleteBatch(value, type) {
      this.$emit('delete', value, type);
    },
  },
};
</script>

<style>
.c-autocomplete {
  position: relative;
}
.c-autocomplete__input {
  border: 1px solid #dbdbdb !important;
  width: 100% !important;
}
.c-autocomplete__input:focus {
  border: 1px solid #dbdbdb !important;
}
.container-filters {
  margin: auto;
  width: 50%;
  color: black;
}
.container-filters li,
.container-filters a {
  list-style: none;
  box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.1);
  color: #000;
}

.container-filters h1 {
  color: #48748a;
  text-align: start;
}
.container-filters h1:first-child {
  border-top: 4px solid #48748a;
}

.container-filters h1,
.container-filters li,
.container-filters a {
  padding: 0.5rem 0 0.5rem 0.6rem;
}
.container-filters li:hover {
  cursor: pointer;
  background-color: #0048ba;
  color: white;
}
.container-filters a:hover {
  cursor: pointer;
  background-color: #0048ba;
  color: white;
}

.autocomplete-results-container {
  width: 100%;
  z-index: 99;
  background-color: white;
  position: absolute;
  left: 0;
  border-radius: 3px;
  display: flex;
  flex-direction: column;
  border: 1px solid black;
  border-top: none;
  box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.1);
  font-size: 16px !important;
}

.button-clear {
  margin-top: 1rem;
}

.c-autocomplete__batch-container {
  width: 100%;
  border-bottom: 1px solid #dbdbdb;
  padding-bottom: 1rem;
}
.c-autocomplete__batch {
  border-radius: 1.625rem;
  background-color: white;
  padding: 0.35rem 1rem 0.5rem 1rem;
  font-weight: 700;
  border: 1px solid #48748a;
  cursor: pointer;
  margin-left: 5px;
  margin-top: 1rem;
  height: auto;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.8);
}
.close-icon {
  margin-left: 0.5rem;
  vertical-align: middle;
}
</style>
