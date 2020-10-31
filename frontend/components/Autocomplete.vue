<template>
  <div ref="c-autocomplete" class="c-autocomplete">
    <div class="c-autocomplete__batch-container">
      <button
        v-for="item in batches"
        :key="item.value"
        class="c-autocomplete__batch"
        @click="deleteBatch(item.value)"
      >
        {{ item.type + ' : ' + item.value }}
      </button>
    </div>
    <input
      v-model="label"
      :name="name + '-label'"
      class="c-autocomplete__input"
      :disabled="isDisabled"
      type="text"
      @keyup="manualChange"
    />
    <h1 v-if="categoryList.length">Categories</h1>
    <button
      v-for="result in categoryList"
      :key="result.name"
      class="auto-complete-button"
      @click="emitSelect(result.name, result.type)"
    >
      {{ result.name }}
    </button>
    <h1 v-if="authorList.length">Authors</h1>
    <button
      v-for="result in authorList"
      :key="result.name"
      class="auto-complete-button"
      @click="emitSelect(result.name, result.type)"
    >
      {{ result.name }}
    </button>
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
  created() {},
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
    },
    deleteBatch(value) {
      this.$store.dispatch('deleteBatch', value);
      this.$emit('delete');
    },
  },
};
</script>

<style></style>
