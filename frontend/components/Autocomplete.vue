<template>
  <div ref="c-autocomplete" class="c-autocomplete">
    <div
      v-if="batches.length && this.$route.path == '/books'"
      class="c-autocomplete__batch-container"
    >
      <button
        v-for="item in batches"
        :key="item.value"
        class="c-autocomplete__batch"
        @click="deleteBatch(item.value)"
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
      v-if="titleList.length || categoryList.length || authorList.length"
      class="autocomplete-results-container"
    >
      <h1 v-if="titleList.length" class="autocomplete-title">Title</h1>
      <nuxt-link
        v-for="result in titleList"
        :key="result.name"
        :to="'/book/' + result.id"
        class="auto-complete-button"
      >
        {{ result.name }}
      </nuxt-link>
      <h1 v-if="categoryList.length" class="autocomplete-title">Categories</h1>
      <li
        v-for="result in categoryList"
        :key="result.name"
        class="auto-complete-button"
        @click="emitSelect(result.name, result.type)"
      >
        {{ result.name }}
      </li>
      <h1 v-if="authorList.length" class="autocomplete-title">Authors</h1>
      <li
        v-for="result in authorList"
        :key="result.name"
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
    name: {
      type: String,
      required: true,
    },
    loading: {
      type: Boolean,
      default: true,
    },
  },
  data() {
    return {
      label: '',
      timeout: null,
      labelChanged: false,
    };
  },
  computed: {
    authorList() {
      return this.$store.state.authorList;
    },
    categoryList() {
      return this.$store.state.categoryList;
    },
    titleList() {
      return this.$store.state.titleList;
    },
    curValue() {
      return this.value;
    },
    isDisabled() {
      return this.disabled;
    },
    batches() {
      return this.$store.state.batches;
    },
  },
  watch: {
    loading(val) {
      if (!val) {
        this.labelChanged = false;
      }
    },
    initLabel: {
      immediate: true,
      handler(label) {
        if (label) {
          this.label = label;
        }
      },
    },
  },
  mounted() {
    document.addEventListener('click', this.emptyAutoList);
  },
  beforeDestroy() {
    document.removeEventListener('click', this.emptyAutoList);
  },
  methods: {
    manualChange() {
      clearTimeout(this.timeout);
      this.labelChanged = true;

      this.timeout = setTimeout(this.emitChange, 1000);
    },
    emitChange() {
      this.$store.dispatch('getAutoCompleteResults', this.label);
    },
    emitSelect(value, type) {
      console.log(value, type);
      this.$store.dispatch('addBatch', { value, type });
      this.$emit('select', { value, type });
      this.$store.dispatch('getAutoCompleteResults', '');
    },
    deleteBatch(value) {
      this.$store.dispatch('deleteBatch', value);
      this.$emit('delete');
    },
    emptyAutoList(e) {
      console.log(e.target);
      if (!this.$el.contains(e.target)) {
        this.$store.dispatch('getAutoCompleteResults', '');
      }
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
  top: 4rem;
  left: 0;
  border-radius: 3px;
  display: flex;
  flex-direction: column;
  border: 1px solid black;
  border-top: none;
  box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.1);
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
